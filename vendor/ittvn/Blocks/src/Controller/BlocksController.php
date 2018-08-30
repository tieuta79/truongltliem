<?php
namespace Blocks\Controller;

use Blocks\Controller\AppController;
 
/**
 * Blocks Controller
 *
 * @property \Blocks\Model\Table\BlocksTable $Blocks
 */
class BlocksController extends AppController
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
    
            $query = $this->Blocks->find();            
                $this->set('blocks', $this->paginate($query));
            $this->set('_serialize', ['blocks']);
    
    }

    /**
     * View method
     *
     * @param string|null $id Block id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $block = $this->Blocks->get($id, [
            'contain' => []
        ]);
        $this->set('block', $block);
        $this->set('_serialize', ['block']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $block = $this->Blocks->newEntity();
        if ($this->request->is('post')) {
            $block = $this->Blocks->patchEntity($block, $this->request->data);
            if ($this->Blocks->save($block)) {
                $this->Flash->success(__('The block has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The block could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('block'));
        $this->set('_serialize', ['block']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Block id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $block = $this->Blocks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $block = $this->Blocks->patchEntity($block, $this->request->data);
            if ($this->Blocks->save($block)) {
                $this->Flash->success(__('The block has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The block could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Blocks,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $this->set(compact('block'));
        $this->set('_serialize', ['block']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Block id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $block = $this->Blocks->get($id);
        if ($this->Blocks->delete($block)) {
            $this->Flash->success(__('The block has been deleted.'));
        } else {
            $this->Flash->error(__('The block could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
