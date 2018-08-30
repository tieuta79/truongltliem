<?php
namespace Metas\Controller;

use Metas\Controller\AppController;

/**
 * Metas Controller
 *
 * @property \Metas\Model\Table\MetasTable $Metas
 */
class MetasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('metas', $this->paginate($this->Metas));
        $this->set('_serialize', ['metas']);
    }

    /**
     * View method
     *
     * @param string|null $id Meta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $meta = $this->Metas->get($id, [
            'contain' => []
        ]);
        $this->set('meta', $meta);
        $this->set('_serialize', ['meta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $meta = $this->Metas->newEntity();
        if ($this->request->is('post')) {
            $meta = $this->Metas->patchEntity($meta, $this->request->data);
            if ($this->Metas->save($meta)) {
                $this->Flash->success(__('The meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The meta could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('meta'));
        $this->set('_serialize', ['meta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Meta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $meta = $this->Metas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $meta = $this->Metas->patchEntity($meta, $this->request->data);
            if ($this->Metas->save($meta)) {
                $this->Flash->success(__('The meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The meta could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('meta'));
        $this->set('_serialize', ['meta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Meta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $meta = $this->Metas->get($id);
        if ($this->Metas->delete($meta)) {
            $this->Flash->success(__('The meta has been deleted.'));
        } else {
            $this->Flash->error(__('The meta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
