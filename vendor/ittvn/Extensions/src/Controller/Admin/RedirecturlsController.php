<?php
namespace Extensions\Controller\Admin;

use Extensions\Controller\AppController;
 
/**
 * Redirecturls Controller
 *
 * @property \Extensions\Model\Table\RedirecturlsTable $Redirecturls
 */
class RedirecturlsController extends AppController
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
        $tableParams = $this->DataTable->tableParams('Redirecturls');
        if (count($tableParams['search']) > 0) {
            $query = $this->Redirecturls->find('search', $this->Redirecturls->filterParams($tableParams['search']));
        } else {
            $query = $this->Redirecturls->find();
        }
                $this->DataTable->table('Redirecturls', $query, $tableParams);
    }
    
    }

    /**
     * View method
     *
     * @param string|null $id Redirecturl id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $redirecturl = $this->Redirecturls->get($id, [
            'contain' => []
        ]);
        $this->set('redirecturl', $redirecturl);
        $this->set('_serialize', ['redirecturl']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $redirecturl = $this->Redirecturls->newEntity();
        if ($this->request->is('post')) {
            $redirecturl = $this->Redirecturls->patchEntity($redirecturl, $this->request->data);
            if ($this->Redirecturls->save($redirecturl)) {
                $this->Flash->success(__('The redirecturl has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The redirecturl could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('redirecturl'));
        $this->set('_serialize', ['redirecturl']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Redirecturl id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $redirecturl = $this->Redirecturls->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $redirecturl = $this->Redirecturls->patchEntity($redirecturl, $this->request->data);
            if ($this->Redirecturls->save($redirecturl)) {
                $this->Flash->success(__('The redirecturl has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The redirecturl could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Redirecturls,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $this->set(compact('redirecturl'));
        $this->set('_serialize', ['redirecturl']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Redirecturl id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $redirecturl = $this->Redirecturls->get($id);
        if ($this->Redirecturls->delete($redirecturl)) {
            $this->Flash->success(__('The redirecturl has been deleted.'));
        } else {
            $this->Flash->error(__('The redirecturl could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function checkredirect($url = null){
        pr($this->request->here); die();
    }
}
