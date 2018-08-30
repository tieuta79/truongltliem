<?php

namespace Sites\Controller\Admin;

use Sites\Controller\AppController;

/**
 * Apis Controller
 *
 * @property \Sites\Model\Table\ApisTable $Apis
 */
class ApisController extends AppController {

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
            $tableParams = $this->DataTable->tableParams('Apis');
            if (count($tableParams['search']) > 0) {
                $query = $this->Apis->find('search', $this->Apis->filterParams($tableParams['search']));
            } else {
                $query = $this->Apis->find();
            }
            $this->DataTable->table('Apis', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Api id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $api = $this->Apis->get($id, [
            'contain' => []
        ]);
        $this->set('api', $api);
        $this->set('_serialize', ['api']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $api = $this->Apis->newEntity();
        if ($this->request->is('post')) {
            $api = $this->Apis->patchEntity($api, $this->request->data);
            if ($this->Apis->save($api)) {
                $this->Flash->success(__('The api has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The api could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('api'));
        $this->set('_serialize', ['api']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Api id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $api = $this->Apis->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $api = $this->Apis->patchEntity($api, $this->request->data);
            if ($this->Apis->save($api)) {
                $this->Flash->success(__('The api has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The api could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Apis, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $this->set(compact('api'));
        $this->set('_serialize', ['api']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Api id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $api = $this->Apis->get($id);
        if ($this->Apis->delete($api)) {
            $this->Flash->success(__('The api has been deleted.'));
        } else {
            $this->Flash->error(__('The api could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
