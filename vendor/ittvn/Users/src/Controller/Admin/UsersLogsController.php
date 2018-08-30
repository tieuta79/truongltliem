<?php
namespace Users\Controller\Admin;

use Users\Controller\AppController;
 
/**
 * UsersLogs Controller
 *
 * @property \Users\Model\Table\UsersLogsTable $UsersLogs
 */
class UsersLogsController extends AppController
{

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
            }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    
    if ($this->request->is('post')) {
        $tableParams = $this->DataTable->tableParams('UsersLogs');
        if (count($tableParams['search']) > 0) {
            $query = $this->UsersLogs->find('search', $this->UsersLogs->filterParams($tableParams['search']));
        } else {
            $query = $this->UsersLogs->find();
        }
                $query->contain(['Logs']);
                $this->DataTable->table('UsersLogs', $query, $tableParams);
    }
    
    }

    /**
     * View method
     *
     * @param string|null $id Users Log id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersLog = $this->UsersLogs->get($id, [
            'contain' => ['Logs']
        ]);
        $this->set('usersLog', $usersLog);
        $this->set('_serialize', ['usersLog']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersLog = $this->UsersLogs->newEntity();
        if ($this->request->is('post')) {
            $usersLog = $this->UsersLogs->patchEntity($usersLog, $this->request->data);
            if ($this->UsersLogs->save($usersLog)) {
                $this->Flash->success(__('The users log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The users log could not be saved. Please, try again.'));
            }
        }
        $logs = $this->UsersLogs->Logs->find('list', ['limit' => 200]);
        $this->set(compact('usersLog', 'logs'));
        $this->set('_serialize', ['usersLog']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Log id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersLog = $this->UsersLogs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersLog = $this->UsersLogs->patchEntity($usersLog, $this->request->data);
            if ($this->UsersLogs->save($usersLog)) {
                $this->Flash->success(__('The users log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The users log could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->UsersLogs,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $logs = $this->UsersLogs->Logs->find('list', ['limit' => 200]);
        $this->set(compact('usersLog', 'logs'));
        $this->set('_serialize', ['usersLog']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Log id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersLog = $this->UsersLogs->get($id);
        if ($this->UsersLogs->delete($usersLog)) {
            $this->Flash->success(__('The users log has been deleted.'));
        } else {
            $this->Flash->error(__('The users log could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
