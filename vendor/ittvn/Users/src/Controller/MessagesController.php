<?php

namespace Users\Controller;

use Users\Controller\AppController;

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
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->loadModel('Users.MessagesUsers');
        $MessagesUsers = $this->MessagesUsers;
        $Users = $this->MessagesUsers->Users;
        $user_id = $this->Auth->user('id');
        $query = $this->Messages->find()
                ->formatResults(function($results) use($MessagesUsers, $Users, $user_id) {
            return $results->map(function ($row) use($MessagesUsers, $Users, $user_id) {
                        $messageUsers = $MessagesUsers->find()
                                ->select(['read','date'])
                                ->where(['user_id' => $user_id, 'message_id' => $row->id])
                                ->group(['user_id', 'message_id']);
                        
                        if(!empty($row->sender)){
                            $row->sender = $Users->find()->select(['id','first_name','middle_name','last_name','email'])->where(['id'=>$user_id])->first();
                        }
                        
                        if ($messageUsers->count() > 0) {
                            $row['messageUsers'] = $messageUsers->toArray();
                        } else {
                            $row['messageUsers'] = [];
                        }

                        return $row;
                    });
        });

        $this->set('messages', $this->paginate($query));
        $this->set('_serialize', ['messages']);

        $this->renderViews([
            'index-' . $this->request->role,
            'index',
        ]);
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
            $message = $this->Messages->patchEntity($message, $this->request->data);
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The message could not be saved. Please, try again.'));
            }
        }
        $users = $this->Messages->Users->find('list', ['limit' => 200]);
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
        $users = $this->Messages->Users->find('list', ['limit' => 200]);
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
