<?php
namespace Extensions\Controller;

use Extensions\Controller\AppController;
 
/**
 * Helps Controller
 *
 * @property \Extensions\Model\Table\HelpsTable $Helps
 */
class HelpsController extends AppController
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
    
            $query = $this->Helps->find();            
                $this->set('helps', $this->paginate($query));
            $this->set('_serialize', ['helps']);
    
    }

    /**
     * View method
     *
     * @param string|null $id Help id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $help = $this->Helps->get($id, [
            'contain' => []
        ]);
        $this->set('help', $help);
        $this->set('_serialize', ['help']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $help = $this->Helps->newEntity();
        if ($this->request->is('post')) {
            $help = $this->Helps->patchEntity($help, $this->request->data);
            if ($this->Helps->save($help)) {
                $this->Flash->success(__('The help has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The help could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('help'));
        $this->set('_serialize', ['help']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Help id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $help = $this->Helps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $help = $this->Helps->patchEntity($help, $this->request->data);
            if ($this->Helps->save($help)) {
                $this->Flash->success(__('The help has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The help could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Helps,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $this->set(compact('help'));
        $this->set('_serialize', ['help']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Help id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $help = $this->Helps->get($id);
        if ($this->Helps->delete($help)) {
            $this->Flash->success(__('The help has been deleted.'));
        } else {
            $this->Flash->error(__('The help could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
