<?php

namespace Users\Controller;

use Users\Controller\AppController;
use Cake\Event\Event;

/**
 * MessagesUsers Controller
 *
 * @property \Users\Model\Table\MessagesUsersTable $MessagesUsers
 */
class MessagesUsersController extends AppController {

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

        $query = $this->MessagesUsers->find();
        $query = $query->contain(['Users', 'Messages']);
        $this->set('messagesUsers', $this->paginate($query));
        $this->set('_serialize', ['messagesUsers']);
    }

    /**
     * View method
     *
     * @param string|null $id Messages User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $messagesUser = $this->MessagesUsers->get($id, [
            'contain' => ['Users', 'Messages']
        ]);
        $this->set('messagesUser', $messagesUser);
        $this->set('_serialize', ['messagesUser']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $messagesUser = $this->MessagesUsers->newEntity();
        if ($this->request->is('post')) {
            $messagesUser = $this->MessagesUsers->patchEntity($messagesUser, $this->request->data);
            if ($this->MessagesUsers->save($messagesUser)) {
                $this->Flash->success(__('The messages user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The messages user could not be saved. Please, try again.'));
            }
        }
        $users = $this->MessagesUsers->Users->find('list', ['limit' => 200]);
        $messages = $this->MessagesUsers->Messages->find('list', ['limit' => 200]);
        $this->set(compact('messagesUser', 'users', 'messages'));
        $this->set('_serialize', ['messagesUser']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Messages User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $messagesUser = $this->MessagesUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $messagesUser = $this->MessagesUsers->patchEntity($messagesUser, $this->request->data);
            if ($this->MessagesUsers->save($messagesUser)) {
                $this->Flash->success(__('The messages user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The messages user could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->MessagesUsers, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $users = $this->MessagesUsers->Users->find('list', ['limit' => 200]);
        $messages = $this->MessagesUsers->Messages->find('list', ['limit' => 200]);
        $this->set(compact('messagesUser', 'users', 'messages'));
        $this->set('_serialize', ['messagesUser']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Messages User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $messagesUser = $this->MessagesUsers->get($id);
        if ($this->MessagesUsers->delete($messagesUser)) {
            $this->Flash->success(__('The messages user has been deleted.'));
        } else {
            $this->Flash->error(__('The messages user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
