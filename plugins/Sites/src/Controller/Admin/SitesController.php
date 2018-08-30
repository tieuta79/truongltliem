<?php

namespace Sites\Controller\Admin;

use Sites\Controller\AppController;
use Cake\Utility\Text;
use Ittvn\Utility\InstallDb;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Settings\Utility\Setting;
use Ittvn\Utility\System;
use Ittvn\Utility\User;
/**
 * Sites Controller
 *
 * @property \Sites\Model\Table\SitesTable $Sites
 */
class SitesController extends AppController {

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Sites');
            if (count($tableParams['search']) > 0) {
                $query = $this->Sites->find('search', $this->Sites->filterParams($tableParams['search']));
            } else {
                $query = $this->Sites->find();
            }
            $query->find('network');
            $this->DataTable->table('Sites', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Site id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $site = $this->Sites->getNetwork($id, [
                    'contain' => ['Domains']
                ]);
        $this->set('site', $site);
        $this->set('_serialize', ['site']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $setting = new Setting();
        $system = new System();

        $role_admin = $setting->getOption('Users.fullPermission');
        $users = $this->Sites->Users->find('list', ['keyField' => 'id', 'valueField' => ['full_name', 'username']])->contain([
                    'Roles' => function($q) use($role_admin) {
                        return $q->where(['slug <>' => $role_admin]);
                    }
                ])->find('network');

        $site = $this->Sites->newEntity();
        if ($this->request->is('post')) {

            $this->request->data['publicKey'] = str_replace('-', '', Text::uuid());
            $this->request->data['privateKey'] = str_replace('-', '', Text::uuid());

            $site = $this->Sites->patchEntity($site, $this->request->data);
            if ($this->Sites->saveNetwork($site)) {
                $username = explode(';', $users->toArray()[$site->user_id]);
                //Create Theme Child
                $themeChild = $system->themeChild(null, trim($username[1]));
                //Install database
                $install = new InstallDb();
                $dbnew = $install->createDb(trim($username[1]));
                $install->createTables(trim($username[1]));
                //Set Theme Active
                $system->activeThemeChild($themeChild, trim($username[1]));
                //Install Permissions
                Configure::write('Site.buildPermission',$dbnew);
                User::buildPermission('sync');

                $this->Flash->success(__('The site has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The site could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('site', 'users'));
        $this->set('_serialize', ['site']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Site id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $setting = new Setting();
        $role_admin = $setting->getOption('Users.fullPermission');
        $users = $this->Sites->Users->find('list', ['keyField' => 'id', 'valueField' => ['full_name', 'username']])->contain([
                    'Roles' => function($q) use($role_admin) {
                        return $q->where(['slug <>' => $role_admin]);
                    }
                ])->find('network');
        $site = $this->Sites->getNetwork($id, [
                    'contain' => []
                ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            unset($this->request->data['publicKey']);
            unset($this->request->data['privateKey']);
            unset($this->request->data['database']);

            $site = $this->Sites->patchEntity($site, $this->request->data);
            if ($this->Sites->saveNetwork($site)) {
                $this->Flash->success(__('The site has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The site could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('site', 'users'));
        $this->set('_serialize', ['site']);
    }

    /**
     * Trash method
     *
     * @param string|null $id Site id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function trash($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $site = $this->Sites->getNetwork($id);
        $site->delete = 1;
        if ($this->Sites->saveNetwork($site)) {
            $this->Flash->success(__('The site has been trash.'));
        } else {
            $this->Flash->error(__('The site could not be trash. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Site id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $system = new System();
        $this->request->allowMethod(['post', 'delete']);
        $site = $this->Sites->getNetwork($id);
        $user = $this->Sites->Users->find()->find('network')->select(['id', 'username'])->where(['id' => $site->user_id])->first();
        if ($this->Sites->deleteNetwork($site)) {
            $install = new InstallDb();
            $install->dropDb($user->username);
            $system->deleteThemeChild($user->username);

            $this->Flash->success(__('The site has been deleted.'));
        } else {
            $this->Flash->error(__('The site could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function change($db = null) {
        if (!empty($db)) {
            if (Configure::check('Network.db')) {
                Configure::delete('Network.db');
            }
            
            if ($db == 'default') {
                Configure::write('Network.db', $db);
                if (Configure::read('Network.type') == 1) {
                    return $this->redirect($this->request->scheme() . '://' . $this->request->host() . '/admin');
                } else {
                    return $this->redirect($this->request->scheme() . '://' . $this->request->domain() . '/admin');
                }
            } else {
                $configDefault = ConnectionManager::get('default')->config();
                Configure::write('Network.db', $db);
                if (Configure::read('Network.type') == 1) {
                    return $this->redirect($this->request->scheme() . '://' . $this->request->host() . '/' . $db . '/admin');
                } else {
                    return $this->redirect($this->request->scheme() . '://' . $db . '.' . $this->request->domain() . '/admin');
                }
            }
        }
        $this->redirect($this->referer());
    }

}
