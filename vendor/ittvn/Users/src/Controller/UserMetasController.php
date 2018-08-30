<?php
namespace Users\Controller;

use Users\Controller\AppController;

/**
 * UserMetas Controller
 *
 * @property \Users\Model\Table\UserMetasTable $UserMetas
 */
class UserMetasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->set('userMetas', $this->paginate($this->UserMetas));
        $this->set('_serialize', ['userMetas']);
    }

    /**
     * View method
     *
     * @param string|null $id User Meta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userMeta = $this->UserMetas->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('userMeta', $userMeta);
        $this->set('_serialize', ['userMeta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userMeta = $this->UserMetas->newEntity();
        if ($this->request->is('post')) {
            $userMeta = $this->UserMetas->patchEntity($userMeta, $this->request->data);
            if ($this->UserMetas->save($userMeta)) {
                $this->Flash->success(__('The user meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user meta could not be saved. Please, try again.'));
            }
        }
        $users = $this->UserMetas->Users->find('list', ['limit' => 200]);
        $this->set(compact('userMeta', 'users'));
        $this->set('_serialize', ['userMeta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Meta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userMeta = $this->UserMetas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userMeta = $this->UserMetas->patchEntity($userMeta, $this->request->data);
            if ($this->UserMetas->save($userMeta)) {
                $this->Flash->success(__('The user meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user meta could not be saved. Please, try again.'));
            }
        }
        $users = $this->UserMetas->Users->find('list', ['limit' => 200]);
        $this->set(compact('userMeta', 'users'));
        $this->set('_serialize', ['userMeta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User Meta id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userMeta = $this->UserMetas->get($id);
        if ($this->UserMetas->delete($userMeta)) {
            $this->Flash->success(__('The user meta has been deleted.'));
        } else {
            $this->Flash->error(__('The user meta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
