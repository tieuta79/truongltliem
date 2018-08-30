<?php
namespace Products\Controller\Admin;

use Products\Controller\AppController;
 
/**
 * Wishlists Controller
 *
 * @property \Products\Model\Table\WishlistsTable $Wishlists
 */
class WishlistsController extends AppController
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
        $tableParams = $this->DataTable->tableParams('Wishlists');
        if (count($tableParams['search']) > 0) {
            $query = $this->Wishlists->find('search', $this->Wishlists->filterParams($tableParams['search']));
        } else {
            $query = $this->Wishlists->find();
        }
                $query->contain(['Contents', 'Users']);
                $this->DataTable->table('Wishlists', $query, $tableParams);
    }
    
    }

    /**
     * View method
     *
     * @param string|null $id Wishlist id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
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
    public function add()
    {
        $wishlist = $this->Wishlists->newEntity();
        if ($this->request->is('post')) {
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
     * Edit method
     *
     * @param string|null $id Wishlist id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
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
        $associations = $this->Ittvn->findBelongsToMany($this->Wishlists,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wishlist = $this->Wishlists->get($id);
        if ($this->Wishlists->delete($wishlist)) {
            $this->Flash->success(__('The wishlist has been deleted.'));
        } else {
            $this->Flash->error(__('The wishlist could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
