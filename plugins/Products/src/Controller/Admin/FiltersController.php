<?php

namespace Products\Controller\Admin;

use Products\Controller\AppController;
use Cake\Event\Event;

/**
 * Filters Controller
 *
 * @property \Products\Model\Table\FiltersTable $Filters
 */
class FiltersController extends AppController {

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
            $tableParams = $this->DataTable->tableParams('Filters');
            if (count($tableParams['search']) > 0) {
                $query = $this->Filters->find('search', $this->Filters->filterParams($tableParams['search']));
            } else {
                $query = $this->Filters->find();
            }
            $this->DataTable->table('Filters', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Filter id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $filter = $this->Filters->get($id, [
            'contain' => []
        ]);
        $this->set('filter', $filter);
        $this->set('_serialize', ['filter']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $filter = $this->Filters->newEntity();
        if ($this->request->is('post')) {
            $filter = $this->Filters->patchEntity($filter, $this->request->data);
            if ($this->Filters->save($filter)) {
                $this->Flash->success(__('The filter has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The filter could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('filter'));
        $this->set('_serialize', ['filter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Filter id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $filter = $this->Filters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $filter = $this->Filters->patchEntity($filter, $this->request->data);
            if ($this->Filters->save($filter)) {
                $this->Flash->success(__('The filter has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The filter could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Filters, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $this->set(compact('filter'));
        $this->set('_serialize', ['filter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Filter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $filter = $this->Filters->get($id);
        if ($this->Filters->delete($filter)) {
            $this->Flash->success(__('The filter has been deleted.'));
        } else {
            $this->Flash->error(__('The filter could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
