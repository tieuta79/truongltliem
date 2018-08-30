<?php

namespace Countries\Controller\Admin;

use Countries\Controller\AppController;

/**
 * Provinces Controller
 *
 * @property \Countries\Model\Table\ProvincesTable $Provinces
 */
class ProvincesController extends AppController {

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
            $tableParams = $this->DataTable->tableParams('Provinces');
            if (count($tableParams['search']) > 0) {
                $query = $this->Provinces->find('search', $this->Provinces->filterParams($tableParams['search']));
            } else {
                $query = $this->Provinces->find();
            }
            $query->contain(['Countries']);
            $this->DataTable->table('Provinces', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Province id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $province = $this->Provinces->get($id, [
            'contain' => ['Countries', 'Addresses', 'Cities']
        ]);
        $this->set('province', $province);
        $this->set('_serialize', ['province']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $province = $this->Provinces->newEntity();
        if ($this->request->is('post')) {
            $province = $this->Provinces->patchEntity($province, $this->request->data);
            if ($this->Provinces->save($province)) {
                $this->Flash->success(__('The province has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The province could not be saved. Please, try again.'));
            }
        }
        $countries = $this->Provinces->Countries->find('list')->where(['delete' => 0]);
        $this->set(compact('province', 'countries'));
        $this->set('_serialize', ['province']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Province id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $province = $this->Provinces->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $province = $this->Provinces->patchEntity($province, $this->request->data);
            if ($this->Provinces->save($province)) {
                $this->Flash->success(__('The province has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The province could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Provinces, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $countries = $this->Provinces->Countries->find('list')->where(['delete' => 0]);
        $this->set(compact('province', 'countries'));
        $this->set('_serialize', ['province']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Province id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $province = $this->Provinces->get($id);
        if ($this->Provinces->delete($province)) {
            $this->Flash->success(__('The province has been deleted.'));
        } else {
            $this->Flash->error(__('The province could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
