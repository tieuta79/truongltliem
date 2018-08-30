<?php
namespace Metas\Controller;

use Metas\Controller\AppController;

/**
 * MetaCategories Controller
 *
 * @property \Metas\Model\Table\MetaCategoriesTable $MetaCategories
 */
class MetaCategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['MetaTypes']
        ];
        $this->set('metaCategories', $this->paginate($this->MetaCategories));
        $this->set('_serialize', ['metaCategories']);
    }

    /**
     * View method
     *
     * @param string|null $id Meta Category id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $metaCategory = $this->MetaCategories->get($id, [
            'contain' => ['MetaTypes', 'Categories']
        ]);
        $this->set('metaCategory', $metaCategory);
        $this->set('_serialize', ['metaCategory']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $metaCategory = $this->MetaCategories->newEntity();
        if ($this->request->is('post')) {
            $metaCategory = $this->MetaCategories->patchEntity($metaCategory, $this->request->data);
            if ($this->MetaCategories->save($metaCategory)) {
                $this->Flash->success(__('The meta category has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The meta category could not be saved. Please, try again.'));
            }
        }
        $metaTypes = $this->MetaCategories->MetaTypes->find('list', ['limit' => 200]);
        $this->set(compact('metaCategory', 'metaTypes'));
        $this->set('_serialize', ['metaCategory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Meta Category id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $metaCategory = $this->MetaCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $metaCategory = $this->MetaCategories->patchEntity($metaCategory, $this->request->data);
            if ($this->MetaCategories->save($metaCategory)) {
                $this->Flash->success(__('The meta category has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The meta category could not be saved. Please, try again.'));
            }
        }
        $metaTypes = $this->MetaCategories->MetaTypes->find('list', ['limit' => 200]);
        $this->set(compact('metaCategory', 'metaTypes'));
        $this->set('_serialize', ['metaCategory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Meta Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $metaCategory = $this->MetaCategories->get($id);
        if ($this->MetaCategories->delete($metaCategory)) {
            $this->Flash->success(__('The meta category has been deleted.'));
        } else {
            $this->Flash->error(__('The meta category could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
