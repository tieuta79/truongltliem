<?php
namespace Contents\Controller\Admin;

use Contents\Controller\AppController;

/**
 * CategoryContents Controller
 *
 * @property \Contents\Model\Table\CategoryContentsTable $CategoryContents
 */
class CategoryContentsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories']
        ];
        $this->set('categoryContents', $this->paginate($this->CategoryContents));
        $this->set('_serialize', ['categoryContents']);
    }

    /**
     * View method
     *
     * @param string|null $id Category Content id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoryContent = $this->CategoryContents->get($id, [
            'contain' => ['Categories', 'Contents']
        ]);
        $this->set('categoryContent', $categoryContent);
        $this->set('_serialize', ['categoryContent']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoryContent = $this->CategoryContents->newEntity();
        if ($this->request->is('post')) {
            $categoryContent = $this->CategoryContents->patchEntity($categoryContent, $this->request->data);
            if ($this->CategoryContents->save($categoryContent)) {
                $this->Flash->success(__('The category content has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category content could not be saved. Please, try again.'));
            }
        }
        $categories = $this->CategoryContents->Categories->find('list', ['limit' => 200]);
        $this->set(compact('categoryContent', 'categories'));
        $this->set('_serialize', ['categoryContent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category Content id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoryContent = $this->CategoryContents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoryContent = $this->CategoryContents->patchEntity($categoryContent, $this->request->data);
            if ($this->CategoryContents->save($categoryContent)) {
                $this->Flash->success(__('The category content has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category content could not be saved. Please, try again.'));
            }
        }
        $categories = $this->CategoryContents->Categories->find('list', ['limit' => 200]);
        $this->set(compact('categoryContent', 'categories'));
        $this->set('_serialize', ['categoryContent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category Content id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoryContent = $this->CategoryContents->get($id);
        if ($this->CategoryContents->delete($categoryContent)) {
            $this->Flash->success(__('The category content has been deleted.'));
        } else {
            $this->Flash->error(__('The category content could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->request->referer());
    }
    
    /**
     * Trash method
     *
     * @param string|null $id Category Content id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function trash($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoryContent = $this->CategoryContents->get($id);
        if ($this->CategoryContents->delete($categoryContent)) {
            $this->Flash->success(__('The category content has been deleted.'));
        } else {
            $this->Flash->error(__('The category content could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->request->referer());
    }    
}
