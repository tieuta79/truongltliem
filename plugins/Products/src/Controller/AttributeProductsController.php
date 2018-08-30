<?php
namespace Products\Controller;

use Products\Controller\AppController;

/**
 * AttributeProducts Controller
 *
 * @property \Products\Model\Table\AttributeProductsTable $AttributeProducts
 */
class AttributeProductsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contents', 'Attributes']
        ];
        $this->set('attributeProducts', $this->paginate($this->AttributeProducts));
        $this->set('_serialize', ['attributeProducts']);
    }

    /**
     * View method
     *
     * @param string|null $id Attribute Product id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attributeProduct = $this->AttributeProducts->get($id, [
            'contain' => ['Contents', 'Attributes']
        ]);
        $this->set('attributeProduct', $attributeProduct);
        $this->set('_serialize', ['attributeProduct']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attributeProduct = $this->AttributeProducts->newEntity();
        if ($this->request->is('post')) {
            $attributeProduct = $this->AttributeProducts->patchEntity($attributeProduct, $this->request->data);
            if ($this->AttributeProducts->save($attributeProduct)) {
                $this->Flash->success(__('The attribute product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attribute product could not be saved. Please, try again.'));
            }
        }
        $contents = $this->AttributeProducts->Contents->find('list', ['limit' => 200]);
        $attributes = $this->AttributeProducts->Attributes->find('list', ['limit' => 200]);
        $this->set(compact('attributeProduct', 'contents', 'attributes'));
        $this->set('_serialize', ['attributeProduct']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Attribute Product id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attributeProduct = $this->AttributeProducts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attributeProduct = $this->AttributeProducts->patchEntity($attributeProduct, $this->request->data);
            if ($this->AttributeProducts->save($attributeProduct)) {
                $this->Flash->success(__('The attribute product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attribute product could not be saved. Please, try again.'));
            }
        }
        $contents = $this->AttributeProducts->Contents->find('list', ['limit' => 200]);
        $attributes = $this->AttributeProducts->Attributes->find('list', ['limit' => 200]);
        $this->set(compact('attributeProduct', 'contents', 'attributes'));
        $this->set('_serialize', ['attributeProduct']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Attribute Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attributeProduct = $this->AttributeProducts->get($id);
        if ($this->AttributeProducts->delete($attributeProduct)) {
            $this->Flash->success(__('The attribute product has been deleted.'));
        } else {
            $this->Flash->error(__('The attribute product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
