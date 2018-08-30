<?php

namespace Products\Controller;

use Products\Controller\AppController;
use Cake\Utility\Hash;
/**
 * Orders Controller
 *
 * @property \Products\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController {

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
        $orders = $this->Orders->find()
                ->contain([
                    'Orderdetails' => function($q){
                        return $q->select(['id','content_id','order_id'])->limit(1)->orderDesc('id');
                    }
                ])
                ->where(['Orders.user_id'=>$this->Auth->user('id'),'Orders.delete'=>0])->orderDesc('Orders.id');
        
        $product_id = [];
        if($orders->count() >0 ){
            $product_id = Hash::extract($orders->toArray(), '{n}.orderdetails.{n}.content_id');
        }
        
        $products = [];
        if(count($product_id) > 0){
            $this->loadModel('Contents.Contents');
            $products = $this->Contents->find('list',['keyField'=>'id','valueField'=>'name'])
                    ->where(['delete'=>0,'status'=>1]);
            if($products->count() > 0){
                $products = $products->toArray();
            }
        }

        $this->set(compact('orders','products'));
        $this->set('_serialize', ['orders']);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'Payments', 'Orderdetails']
        ]);
        $this->set('order', $order);
        $this->set('_serialize', ['order']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->data);
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order could not be saved. Please, try again.'));
            }
        }
        $users = $this->Orders->Users->find('list', ['limit' => 200]);
        $payments = $this->Orders->Payments->find('list', ['limit' => 200]);
        $this->set(compact('order', 'users', 'payments'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->data);
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Orders, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $users = $this->Orders->Users->find('list', ['limit' => 200]);
        $payments = $this->Orders->Payments->find('list', ['limit' => 200]);
        $this->set(compact('order', 'users', 'payments'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
