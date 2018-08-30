<?php

namespace Sites\Controller\Admin;

use Sites\Controller\AppController;

/**
 * Domains Controller
 *
 * @property \Sites\Model\Table\DomainsTable $Domains
 */
class DomainsController extends AppController {

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {

        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Domains');
            if (count($tableParams['search']) > 0) {
                $query = $this->Domains->find('search', $this->Domains->filterParams($tableParams['search']));
            } else {
                $query = $this->Domains->find();
            }
            $query->contain(['Sites']);
            $this->DataTable->table('Domains', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Domain id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $domain = $this->Domains->get($id, [
            'contain' => ['Sites']
        ]);
        $this->set('domain', $domain);
        $this->set('_serialize', ['domain']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $domain = $this->Domains->newEntity();
        if ($this->request->is('post')) {
            $domain = $this->Domains->patchEntity($domain, $this->request->data);
            if ($this->Domains->save($domain)) {
                $this->Flash->success(__('The domain has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The domain could not be saved. Please, try again.'));
            }
        }
        $sites = $this->Domains->Sites->find('list', ['limit' => 200]);
        $this->set(compact('domain', 'sites'));
        $this->set('_serialize', ['domain']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Domain id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $domain = $this->Domains->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $domain = $this->Domains->patchEntity($domain, $this->request->data);
            if ($this->Domains->save($domain)) {
                $this->Flash->success(__('The domain has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The domain could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Domains, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $sites = $this->Domains->Sites->find('list', ['limit' => 200]);
        $this->set(compact('domain', 'sites'));
        $this->set('_serialize', ['domain']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Domain id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $domain = $this->Domains->get($id);
        if ($this->Domains->delete($domain)) {
            $this->Flash->success(__('The domain has been deleted.'));
        } else {
            $this->Flash->error(__('The domain could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
