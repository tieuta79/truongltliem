<?php

namespace Products\Controller;

use Products\Controller\AppController;

/**
 * Addresses Controller
 *
 * @property \Products\Model\Table\AddressesTable $Addresses
 */
class AddressesController extends AppController {

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
        $query = $this->Addresses->find();
        $query = $query->contain(['Countries', 'Provinces', 'Cities', 'Wards']);
        $this->set('addresses', $this->paginate($query));
        $this->set('_serialize', ['addresses']);
    }

    /**
     * View method
     *
     * @param string|null $id Address id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $address = $this->Addresses->get($id, [
            'contain' => ['Countries', 'Provinces', 'Cities', 'Wards', 'Users']
        ]);
        $this->set('address', $address);
        $this->set('_serialize', ['address']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $address = $this->Addresses->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Auth->user('id');
            $address = $this->Addresses->patchEntity($address, $this->request->data);
            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('The address has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The address could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('address'));
        $this->set('_serialize', ['address']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Address id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $address = $this->Addresses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $address = $this->Addresses->patchEntity($address, $this->request->data);
            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('The address has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The address could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('address'));
        $this->set('_serialize', ['address']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Address id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $address = $this->Addresses->get($id);
        if ($this->Addresses->delete($address)) {
            $this->Flash->success(__('The address has been deleted.'));
        } else {
            $this->Flash->error(__('The address could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
