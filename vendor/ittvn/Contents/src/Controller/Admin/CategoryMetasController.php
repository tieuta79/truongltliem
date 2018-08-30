<?php
namespace Contents\Controller\Admin;

use Contents\Controller\AppController;

/**
 * CategoryMetas Controller
 *
 * @property \Contents\Model\Table\CategoryMetasTable $CategoryMetas
 */
class CategoryMetasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('categoryMetas', $this->paginate($this->CategoryMetas));
        $this->set('_serialize', ['categoryMetas']);
    }

    /**
     * View method
     *
     * @param string|null $id Category Meta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoryMeta = $this->CategoryMetas->get($id, [
            'contain' => ['Categories']
        ]);
        $this->set('categoryMeta', $categoryMeta);
        $this->set('_serialize', ['categoryMeta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoryMeta = $this->CategoryMetas->newEntity();
        if ($this->request->is('post')) {
            $categoryMeta = $this->CategoryMetas->patchEntity($categoryMeta, $this->request->data);
            if ($this->CategoryMetas->save($categoryMeta)) {
                $this->Flash->success(__('The category meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category meta could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('categoryMeta'));
        $this->set('_serialize', ['categoryMeta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category Meta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoryMeta = $this->CategoryMetas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoryMeta = $this->CategoryMetas->patchEntity($categoryMeta, $this->request->data);
            if ($this->CategoryMetas->save($categoryMeta)) {
                $this->Flash->success(__('The category meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category meta could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('categoryMeta'));
        $this->set('_serialize', ['categoryMeta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category Meta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoryMeta = $this->CategoryMetas->get($id);
        if ($this->CategoryMetas->delete($categoryMeta)) {
            $this->Flash->success(__('The category meta has been deleted.'));
        } else {
            $this->Flash->error(__('The category meta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
