<?php

namespace Products\Controller\Admin;

use Products\Controller\AppController;

/**
 * Attributes Controller
 *
 * @property \Products\Model\Table\AttributesTable $Attributes
 */
class AttributesController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Attributes');
            if (count($tableParams['search']) > 0) {
                $query = $this->Attributes->find('search', $this->Attributes->filterParams($tableParams['search']));
            } else {
                $query = $this->Attributes->find();
            }

            $this->DataTable->table('Attributes', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Attribute id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $attribute = $this->Attributes->get($id, [
            'contain' => ['AttributeProducts']
        ]);
        $this->set('attribute', $attribute);
        $this->set('_serialize', ['attribute']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $attribute = $this->Attributes->newEntity();
        if ($this->request->is('post')) {
            $attribute = $this->Attributes->patchEntity($attribute, $this->request->data);
            if ($this->Attributes->save($attribute)) {
                $this->Flash->success(__('The attribute has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attribute could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('attribute'));
        $this->set('_serialize', ['attribute']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Attribute id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $attribute = $this->Attributes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attribute = $this->Attributes->patchEntity($attribute, $this->request->data);
            if ($this->Attributes->save($attribute)) {
                $this->Flash->success(__('The attribute has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attribute could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('attribute'));
        $this->set('_serialize', ['attribute']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Attribute id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $attribute = $this->Attributes->get($id);
        if ($this->Attributes->delete($attribute)) {
            $this->Flash->success(__('The attribute has been deleted.'));
        } else {
            $this->Flash->error(__('The attribute could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
