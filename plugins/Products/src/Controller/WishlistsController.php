<?php

namespace Products\Controller;

use Products\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
/**
 * Wishlists Controller
 *
 * @property \Products\Model\Table\WishlistsTable $Wishlists
 */
class WishlistsController extends AppController {

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['add']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $wishlists = $this->Wishlists->find()
                ->where(['user_id'=>$this->Auth->user('id'),'delete'=>0])
                ->formatResults(function ($results){
                    $Content = TableRegistry::get('Contents.Contents');
                    return $results->map(function ($row) use($Content) {
                        $row['content'] = $Content->find()->select(['id','name','slug'])
                                ->contain([
                                    'ContentMetas' => function($q) {
                                        return $q->select(['id', 'key', 'value', 'content_id'])->where(['key'=>'Price']);
                                    }])
                                ->where(['status'=>1, 'delete'=>0,'id'=>$row->content_id])->first();
                        return $row;
                    });
                });
        //pr($wishlists->toArray());die();
        $this->set('wishlists', $wishlists);
        $this->set('_serialize', ['wishlists']);
    }

    /**
     * View method
     *
     * @param string|null $id Wishlist id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $wishlist = $this->Wishlists->get($id, [
            'contain' => ['Contents', 'Users']
        ]);
        $this->set('wishlist', $wishlist);
        $this->set('_serialize', ['wishlist']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $return = ['status'=>false,'data'=>[]];
        if($this->Auth->user('id')){
            $wishlist = $this->Wishlists->newEntity();
            if ($this->request->is('post')) {
                $check = $this->Wishlists->findByContentId($this->request->data['content_id']);
                if($check->count()==0){
                    $this->request->data['user_id'] = $this->Auth->user('id');
                    $wishlist = $this->Wishlists->patchEntity($wishlist, $this->request->data);
                    if ($this->Wishlists->save($wishlist)) {
                        $return['data'] = __d('ittvn','The wishlist has been saved.');
                    } else {
                        $return['data'] = __d('ittvn','The wishlist has been saved.');
                    }
                }else{
                    $return['data'] = __d('ittvn','The wishlist has been saved.');
                }
            }
        }else{
            $return['data'] = __d('ittvn','Please login and add again.');
        }
        $return['status'] = true;
        
        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }

    /**
     * Edit method
     *
     * @param string|null $id Wishlist id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $wishlist = $this->Wishlists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wishlist = $this->Wishlists->patchEntity($wishlist, $this->request->data);
            if ($this->Wishlists->save($wishlist)) {
                $this->Flash->success(__('The wishlist has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The wishlist could not be saved. Please, try again.'));
            }
        }

        $contents = $this->Wishlists->Contents->find('list', ['limit' => 200]);
        $users = $this->Wishlists->Users->find('list', ['limit' => 200]);
        $this->set(compact('wishlist', 'contents', 'users'));
        $this->set('_serialize', ['wishlist']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Wishlist id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete() {
        $return = ['status'=>false,'data'=>[]];
        $this->request->allowMethod(['post', 'delete']);
        $wishlist = $this->Wishlists->get($this->request->data['id']);
        if ($this->Wishlists->delete($wishlist)) {
            $return['status'] = true;
        }
        $this->set('return', $return);
        $this->set('_serialize', 'return');
    }

}
