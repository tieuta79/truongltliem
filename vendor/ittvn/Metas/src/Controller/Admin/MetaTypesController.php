<?php

namespace Metas\Controller\Admin;

use Metas\Controller\AppController;
use Ittvn\Utility\System;

/**
 * MetaTypes Controller
 *
 * @property \Metas\Model\Table\MetaTypesTable $MetaTypes
 */
class MetaTypesController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $tableParams = $this->DataTable->tableParams('MetaTypes');
        if (count($tableParams['search']) > 0) {
            $query = $this->MetaTypes->find('search', $this->MetaTypes->filterParams($tableParams['search']));
        } else {
            $query = $this->MetaTypes->find();
        }
        $query->find('network');

        $this->DataTable->table('MetaTypes', $query, $tableParams);
    }

    /**
     * View method
     *
     * @param string|null $id Meta Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $metaType = $this->MetaTypes->getNetwork($id, [
            'contain' => []
        ]);
        $this->set('metaType', $metaType);
        $this->set('_serialize', ['metaType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $metaType = $this->MetaTypes->newEntity();
        if ($this->request->is('post')) {
            $metaType = $this->MetaTypes->patchEntity($metaType, $this->request->data);
            if ($this->MetaTypes->saveNetwork($metaType)) {
                $this->Flash->success(__('The meta type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The meta type could not be saved. Please, try again.'));
            }
        }
        $models = (new System())->modelsContentTypes();
        $this->set(compact('metaType', 'models'));
        $this->set('_serialize', ['metaType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Meta Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $metaType = $this->MetaTypes->getNetwork($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $metaType = $this->MetaTypes->patchEntity($metaType, $this->request->data);
            if ($this->MetaTypes->saveNetwork($metaType)) {
                $this->Flash->success(__('The meta type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The meta type could not be saved. Please, try again.'));
            }
        }
        $models = (new System())->modelsContentTypes();
        $this->set(compact('metaType', 'models'));
        $this->set('_serialize', ['metaType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Meta Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $metaType = $this->MetaTypes->getNetwork($id);
        if ($this->MetaTypes->deleteNetwork($metaType)) {
            $this->Flash->success(__('The meta type has been deleted.'));
        } else {
            $this->Flash->error(__('The meta type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Trash method
     *
     * @param string|null $id Meta Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function trash($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $metaType = $this->MetaTypes->getNetwork($id);
        if ($this->MetaTypes->deleteNetwork($metaType)) {
            $this->Flash->success(__('The meta type has been deleted.'));
        } else {
            $this->Flash->error(__('The meta type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }    

}
