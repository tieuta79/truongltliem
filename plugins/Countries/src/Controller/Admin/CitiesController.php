<?php

namespace Countries\Controller\Admin;

use Countries\Controller\AppController;

/**
 * Cities Controller
 *
 * @property \Countries\Model\Table\CitiesTable $Cities
 */
class CitiesController extends AppController {

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

        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Cities');
            if (count($tableParams['search']) > 0) {
                $query = $this->Cities->find('search', $this->Cities->filterParams($tableParams['search']));
            } else {
                $query = $this->Cities->find();
            }
            $query->contain(['Provinces', 'Countries']);
            $this->DataTable->table('Cities', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id City id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $city = $this->Cities->get($id, [
            'contain' => ['Provinces', 'Countries', 'Addresses']
        ]);
        $this->set('city', $city);
        $this->set('_serialize', ['city']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $city = $this->Cities->newEntity();
        if ($this->request->is('post')) {
            $city = $this->Cities->patchEntity($city, $this->request->data);
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The city could not be saved. Please, try again.'));
            }
        }
        $provinces = $this->Cities->Provinces->find('list')->where(['delete' => 0]);
        $countries = $this->Cities->Countries->find('list')->where(['delete' => 0]);
        $this->set(compact('city', 'provinces', 'countries'));
        $this->set('_serialize', ['city']);
    }

    /**
     * Edit method
     *
     * @param string|null $id City id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $city = $this->Cities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $city = $this->Cities->patchEntity($city, $this->request->data);
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The city could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Cities, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $provinces = $this->Cities->Provinces->find('list')->where(['delete' => 0]);
        $countries = $this->Cities->Countries->find('list')->where(['delete' => 0]);
        $this->set(compact('city', 'provinces', 'countries'));
        $this->set('_serialize', ['city']);
    }

    /**
     * Delete method
     *
     * @param string|null $id City id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $city = $this->Cities->get($id);
        if ($this->Cities->delete($city)) {
            $this->Flash->success(__('The city has been deleted.'));
        } else {
            $this->Flash->error(__('The city could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
