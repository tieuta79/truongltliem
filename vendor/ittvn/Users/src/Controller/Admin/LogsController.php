<?php

namespace Users\Controller\Admin;

use Users\Controller\AppController;

/**
 * Logs Controller
 *
 * @property \Users\Model\Table\LogsTable $Logs
 */
class LogsController extends AppController {

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
            $tableParams = $this->DataTable->tableParams('Logs');
            if (count($tableParams['search']) > 0) {
                $query = $this->Logs->find('search', $this->Logs->filterParams($tableParams['search']));
            } else {
                $query = $this->Logs->find();
            }
            $query->contain(['Users']);
            $this->DataTable->table('Logs', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Log id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $log = $this->Logs->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('log', $log);
        $this->set('_serialize', ['log']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $log = $this->Logs->newEntity();
        if ($this->request->is('post')) {
            $log = $this->Logs->patchEntity($log, $this->request->data);
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The log could not be saved. Please, try again.'));
            }
        }
        $users = $this->Logs->Users->find('list', ['limit' => 200]);
        $this->set(compact('log', 'users'));
        $this->set('_serialize', ['log']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Log id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $log = $this->Logs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $log = $this->Logs->patchEntity($log, $this->request->data);
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The log could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Logs, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $users = $this->Logs->Users->find('list', ['limit' => 200]);
        $this->set(compact('log', 'users'));
        $this->set('_serialize', ['log']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Log id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $log = $this->Logs->get($id);
        if ($this->Logs->delete($log)) {
            $this->Flash->success(__('The log has been deleted.'));
        } else {
            $this->Flash->error(__('The log could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
