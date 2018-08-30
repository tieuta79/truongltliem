<?php
namespace Translates\Controller;

use Translates\Controller\AppController;
 
/**
 * Translates Controller
 *
 * @property \Translates\Model\Table\TranslatesTable $Translates
 */
class TranslatesController extends AppController
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
    
            $query = $this->Translates->find();            
                $query = $query->contain(['Languages', 'Locales']);
                $this->set('translates', $this->paginate($query));
            $this->set('_serialize', ['translates']);
    
    }

    /**
     * View method
     *
     * @param string|null $id Translate id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $translate = $this->Translates->get($id, [
            'contain' => ['Languages', 'Locales']
        ]);
        $this->set('translate', $translate);
        $this->set('_serialize', ['translate']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $translate = $this->Translates->newEntity();
        if ($this->request->is('post')) {
            $translate = $this->Translates->patchEntity($translate, $this->request->data);
            if ($this->Translates->save($translate)) {
                $this->Flash->success(__('The translate has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The translate could not be saved. Please, try again.'));
            }
        }
        $languages = $this->Translates->Languages->find('list', ['limit' => 200]);
        $locales = $this->Translates->Locales->find('list', ['limit' => 200]);
        $this->set(compact('translate', 'languages', 'locales'));
        $this->set('_serialize', ['translate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Translate id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $translate = $this->Translates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $translate = $this->Translates->patchEntity($translate, $this->request->data);
            if ($this->Translates->save($translate)) {
                $this->Flash->success(__('The translate has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The translate could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Translates,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $languages = $this->Translates->Languages->find('list', ['limit' => 200]);
        $locales = $this->Translates->Locales->find('list', ['limit' => 200]);
        $this->set(compact('translate', 'languages', 'locales'));
        $this->set('_serialize', ['translate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Translate id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $translate = $this->Translates->get($id);
        if ($this->Translates->delete($translate)) {
            $this->Flash->success(__('The translate has been deleted.'));
        } else {
            $this->Flash->error(__('The translate could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
