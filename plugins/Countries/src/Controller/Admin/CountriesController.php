<?php

namespace Countries\Controller\Admin;

use Countries\Controller\AppController;

/**
 * Countries Controller
 *
 * @property \Countries\Model\Table\CountriesTable $Countries
 */
class CountriesController extends AppController {

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
            $tableParams = $this->DataTable->tableParams('Countries');
            if (count($tableParams['search']) > 0) {
                $query = $this->Countries->find('search', $this->Countries->filterParams($tableParams['search']));
            } else {
                $query = $this->Countries->find();
            }
            $this->DataTable->table('Countries', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Country id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $country = $this->Countries->get($id, [
            'contain' => ['Addresses', 'Cities', 'Provinces']
        ]);
        $this->set('country', $country);
        $this->set('_serialize', ['country']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $country = $this->Countries->newEntity();
        if ($this->request->is('post')) {
            $country = $this->Countries->patchEntity($country, $this->request->data);
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('The country has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The country could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('country'));
        $this->set('_serialize', ['country']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Country id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $country = $this->Countries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $country = $this->Countries->patchEntity($country, $this->request->data);
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('The country has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The country could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Countries, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $this->set(compact('country'));
        $this->set('_serialize', ['country']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Country id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $country = $this->Countries->get($id);
        if ($this->Countries->delete($country)) {
            $this->Flash->success(__('The country has been deleted.'));
        } else {
            $this->Flash->error(__('The country could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
