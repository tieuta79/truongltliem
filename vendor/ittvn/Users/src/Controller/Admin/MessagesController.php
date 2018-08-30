<?php

namespace Users\Controller\Admin;

use Users\Controller\AppController;
use Cake\Event\Event;
use Ittvn\Utility\User;
/**
 * Messages Controller
 *
 * @property \Users\Model\Table\MessagesTable $Messages
 */
class MessagesController extends AppController {

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
            $tableParams = $this->DataTable->tableParams('Messages');
            if (count($tableParams['search']) > 0) {
                $query = $this->Messages->find('search', $this->Messages->filterParams($tableParams['search']));
            } else {
                $query = $this->Messages->find();
            }
            $this->DataTable->table('Messages', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $message = $this->Messages->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('message', $message);
        $this->set('_serialize', ['message']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $message = $this->Messages->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['sender'] = $this->Auth->user('id');
            $message = $this->Messages->patchEntity($message, $this->request->data);
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The message could not be saved. Please, try again.'));
            }
        }
        $users = $this->Messages->Users->find('list', ['limit' => 200])->where(['role_id <>' => 1]);
        $this->set(compact('message', 'users'));
        $this->set('_serialize', ['message']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $message = $this->Messages->get($id, [
            'contain' => ['Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['sender'] = $this->Auth->user('id');
            $message = $this->Messages->patchEntity($message, $this->request->data);
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The message could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Messages, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $users = $this->Messages->Users->find('list', ['limit' => 200])->where(['role_id <>' => 1]);
        $this->set(compact('message', 'users'));
        $this->set('_serialize', ['message']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
