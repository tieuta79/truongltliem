<?php
namespace Products\Controller\Admin;

use Products\Controller\AppController;
 
/**
 * Orderdetails Controller
 *
 * @property \Products\Model\Table\OrderdetailsTable $Orderdetails
 */
class OrderdetailsController extends AppController
{

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
            }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    
    if ($this->request->is('post')) {
        $tableParams = $this->DataTable->tableParams('Orderdetails');
        if (count($tableParams['search']) > 0) {
            $query = $this->Orderdetails->find('search', $this->Orderdetails->filterParams($tableParams['search']));
        } else {
            $query = $this->Orderdetails->find();
        }
                $query->contain(['Contents']);
                $this->DataTable->table('Orderdetails', $query, $tableParams);
    }
    
    }

    /**
     * View method
     *
     * @param string|null $id Orderdetail id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderdetail = $this->Orderdetails->get($id, [
            'contain' => ['Contents', 'Orders']
        ]);
        $this->set('orderdetail', $orderdetail);
        $this->set('_serialize', ['orderdetail']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderdetail = $this->Orderdetails->newEntity();
        if ($this->request->is('post')) {
            $orderdetail = $this->Orderdetails->patchEntity($orderdetail, $this->request->data);
            if ($this->Orderdetails->save($orderdetail)) {
                $this->Flash->success(__('The orderdetail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The orderdetail could not be saved. Please, try again.'));
            }
        }
        $contents = $this->Orderdetails->Contents->find('list', ['limit' => 200]);
        $this->set(compact('orderdetail', 'contents'));
        $this->set('_serialize', ['orderdetail']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Orderdetail id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderdetail = $this->Orderdetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderdetail = $this->Orderdetails->patchEntity($orderdetail, $this->request->data);
            if ($this->Orderdetails->save($orderdetail)) {
                $this->Flash->success(__('The orderdetail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The orderdetail could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Orderdetails,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $contents = $this->Orderdetails->Contents->find('list', ['limit' => 200]);
        $this->set(compact('orderdetail', 'contents'));
        $this->set('_serialize', ['orderdetail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Orderdetail id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderdetail = $this->Orderdetails->get($id);
        if ($this->Orderdetails->delete($orderdetail)) {
            $this->Flash->success(__('The orderdetail has been deleted.'));
        } else {
            $this->Flash->error(__('The orderdetail could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
