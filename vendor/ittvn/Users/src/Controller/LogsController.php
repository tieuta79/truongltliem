<?php

namespace Users\Controller;

use Users\Controller\AppController;
use Cake\Event\Event;
use Ittvn\Utility\User;
/**
 * Logs Controller
 *
 * @property \Users\Model\Table\LogsTable $Logs
 */
class LogsController extends AppController {

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
        $query = $this->Logs->find()->where(['user_id' => $this->Auth->user(User::getSessionKey().'.id')]);

        $this->set('logs', $this->paginate($query));
        $this->set('_serialize', ['logs']);

        $this->renderViews([
            'index-' . $this->request->role,
            'index',
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id Log id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $log = $this->Logs->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('log', $log);
        $this->set('_serialize', ['log']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $log = $this->Logs->newEntity();
        if ($this->request->is('post')) {
            $log = $this->Logs->patchEntity($log, $this->request->data);
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The log could not be saved. Please, try again.'));
            }
        }
        $users = $this->Logs->Users->find('list', ['limit' => 200]);
        $this->set(compact('log', 'users'));
        $this->set('_serialize', ['log']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Log id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $log = $this->Logs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $log = $this->Logs->patchEntity($log, $this->request->data);
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The log could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Logs, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $users = $this->Logs->Users->find('list', ['limit' => 200]);
        $this->set(compact('log', 'users'));
        $this->set('_serialize', ['log']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Log id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $log = $this->Logs->get($id);
        if ($this->Logs->delete($log)) {
            $this->Flash->success(__('The log has been deleted.'));
        } else {
            $this->Flash->error(__('The log could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
