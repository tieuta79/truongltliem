<?php
namespace Contents\Controller\Admin;

use Contents\Controller\AppController;

/**
 * ContentMetas Controller
 *
 * @property \Contents\Model\Table\ContentMetasTable $ContentMetas
 */
class ContentMetasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('contentMetas', $this->paginate($this->ContentMetas));
        $this->set('_serialize', ['contentMetas']);
    }

    /**
     * View method
     *
     * @param string|null $id Content Meta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contentMeta = $this->ContentMetas->get($id, [
            'contain' => ['Contents']
        ]);
        $this->set('contentMeta', $contentMeta);
        $this->set('_serialize', ['contentMeta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contentMeta = $this->ContentMetas->newEntity();
        if ($this->request->is('post')) {
            $contentMeta = $this->ContentMetas->patchEntity($contentMeta, $this->request->data);
            if ($this->ContentMetas->save($contentMeta)) {
                $this->Flash->success(__('The content meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The content meta could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('contentMeta'));
        $this->set('_serialize', ['contentMeta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Content Meta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contentMeta = $this->ContentMetas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contentMeta = $this->ContentMetas->patchEntity($contentMeta, $this->request->data);
            if ($this->ContentMetas->save($contentMeta)) {
                $this->Flash->success(__('The content meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The content meta could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('contentMeta'));
        $this->set('_serialize', ['contentMeta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Content Meta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contentMeta = $this->ContentMetas->get($id);
        if ($this->ContentMetas->delete($contentMeta)) {
            $this->Flash->success(__('The content meta has been deleted.'));
        } else {
            $this->Flash->error(__('The content meta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
