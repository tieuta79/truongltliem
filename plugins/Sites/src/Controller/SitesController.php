<?php

namespace Sites\Controller;

use Sites\Controller\AppController;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Plugin;
use Settings\Utility\Setting;
use Cake\Utility\Text;
use Ittvn\Utility\InstallDb;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Query;
use Users\Model\Entity\User;

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
        $this->Auth->allow(['home']);
    }

    public function home() {
        
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $query = $this->Sites->find();
        $query = $query->contain(['Users']);
        $this->set('sites', $this->paginate($query));
        $this->set('_serialize', ['sites']);
    }

    /**
     * View method
     *
     * @param string|null $id Site id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $site = $this->Sites->get($id, [
            'contain' => ['Users', 'Domains']
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
        $site = $this->Sites->newEntity();
        if ($this->request->is('post')) {
            $site = $this->Sites->patchEntity($site, $this->request->data);
            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The site could not be saved. Please, try again.'));
            }
        }
        $users = $this->Sites->Users->find('list', ['limit' => 200]);
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
        $site = $this->Sites->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $site = $this->Sites->patchEntity($site, $this->request->data);
            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The site could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Sites, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $users = $this->Sites->Users->find('list', ['limit' => 200]);
        $this->set(compact('site', 'users'));
        $this->set('_serialize', ['site']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Site id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $site = $this->Sites->get($id);
        if ($this->Sites->delete($site)) {
            $this->Flash->success(__('The site has been deleted.'));
        } else {
            $this->Flash->error(__('The site could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * website method
     *
     * @param string|null $id Site id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function website() {
        $return = ['status' => false, 'data' => [], 'message' => ''];
        $db_exist = false;
        $site = $this->Sites->find()->where(['user_id' => $this->Auth->user('id')]);

        $this->loadModel('Users.Users');
        $user = $this->Users->find()
                        ->select(['Users.id', 'Users.username'])
                        ->contain(['UserMetas' => function($q) {
                                return $q->select(['id', 'key', 'value', 'user_id'])
                                        ->where(['key' => 'school_db_examble']);
                            }])
                        ->where(['Users.id' => $this->Auth->user('id')])->first();

        if ($site->count() > 0) {
            $site = $site->first();
            $db_exist = true;
        } else {
            $site = $this->Sites->newEntity();
            $site->user_id = $this->Auth->user('id');
            $site->publicKey = str_replace('-', '', Text::uuid());
            $site->privateKey = str_replace('-', '', Text::uuid());
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $site = $this->Sites->patchEntity($site, $this->request->data);
            if ($this->Sites->save($site)) {
                if ($db_exist == false) {
                    //Install database
                    $install = new InstallDb();
                    $install->createDb($this->Auth->user('username'));
                    $install->createTables($this->Auth->user('username'));
                }
                //install theme
                if ($this->request->data('theme_name')) {
                    $db = ConnectionManager::get('default');
                    $siteDb = $db->config()['database'] . '_' . $this->request->session()->read('Auth.User.username');
                    $this->loadModel('Settings.Settings');
                    $setting = $this->Settings->find('all', array('conditions' => array('Settings.name' => 'Themes.site')))
                                    ->connection(ConnectionManager::get($siteDb))->first();

                    $setting->value = $this->request->data('theme_name');
                    $this->Settings->connection(ConnectionManager::get($siteDb));
                    $this->Settings->save($setting);
                }


                //install database demo
                $this->set('user', $user);
                if ($user->school_db_examble_meta != 1) {
                    if (!empty($this->request->data['Database_demo'])) {
                        $db = ConnectionManager::get('default');
                        $siteDb = $db->config()['database'] . '_' . $this->request->session()->read('Auth.User.username');
                        $connection = ConnectionManager::get($siteDb);
                        $connection->execute($this->request->data('database_demo_name'));
                        //bookmark install db example
                        $this->loadModel('Users.UserMetas');
                        $user = $this->UserMetas->newEntity([
                            'key' => 'school_db_examble',
                            'value' => 1,
                            'user_id' => $this->request->session()->read('Auth.User.id')
                        ]);
                        $this->UserMetas->save($user);
                    }
                }

                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                    $return['status'] = true;
                    $return['data'] = $site;
                    $return['message'] = __d('ittvn', 'Cập nhật thông tin website thành công.');
                } else {
                    $this->Flash->success(__d('ittvn', 'Cập nhật thông tin website thành công.'));
                }
            } else {
                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                    $return['message'] = __d('ittvn', 'Lỗi cập nhật thông tin website.');
                } else {
                    $this->Flash->error(__d('ittvn', 'Lỗi cập nhật thông tin website.'));
                }
            }
        }
        $this->set('check_hidden',$user->school_db_examble_meta);
        $info_theme = '';
        $setting = new Setting();
        $theme = $setting->getOption('Sites.theme_default');
        $theme_path = Plugin::path($theme);
        $dir = new Folder($theme_path);
        $json_p = $dir->findRecursive('template.json');
        if (count($json_p) > 0) {
            $file_infor = new File($json_p[0]);
            $info_theme = json_decode($file_infor->read());
            unset($info_theme->admin);
        }

        if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
            $this->set(compact('return'));
            $this->set('_serialize', 'return');
        } else {
            $this->loadModel('Sites.Domains');
            $domain = $this->Domains->find()->where(['site_id' => $site->id]);
            if ($domain->count() > 0) {
                $domain = $domain->first();
            } else {
                $domain = $this->Domains->newEntity();
            }

            $this->set(compact('site', 'domain', 'theme', 'info_theme'));
            $this->set('_serialize', 'site');

            $this->renderViews([
                'website-' . $this->request->role,
                'website',
            ]);
        }
    }

}
