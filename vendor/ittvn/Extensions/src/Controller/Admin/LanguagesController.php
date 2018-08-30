<?php

namespace Extensions\Controller\Admin;

use Extensions\Controller\AppController;
use Cake\Event\Event;

/**
 * Languages Controller
 *
 * @property \Extensions\Model\Table\LanguagesTable $Languages
 */
class LanguagesController extends AppController {

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Languages');
            if (count($tableParams['search']) > 0) {
                $query = $this->Languages->find('search', $this->Languages->filterParams($tableParams['search']));
            } else {
                $query = $this->Languages->find();
            }
            $query->find('network');
            $this->DataTable->table('Languages', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Language id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $language = $this->Languages->get($id, [
                    'contain' => []
                ])->find('network');
        $this->set('language', $language);
        $this->set('_serialize', ['language']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $language = $this->Languages->newEntity();
        if ($this->request->is('post')) {
            $language = $this->Languages->patchEntity($language, $this->request->data);
            if ($this->Languages->saveNetWork($language)) {
                $this->Flash->success(__('The language has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The language could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('language'));
        $this->set('_serialize', ['language']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Language id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $language = $this->Languages->getNetwork($id, [
                    'contain' => []
                ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $language = $this->Languages->patchEntity($language, $this->request->data);
            if ($this->Languages->saveNetwork($language)) {
                $this->Flash->success(__('The language has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The language could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('language'));
        $this->set('_serialize', ['language']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Language id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $language = $this->Languages->getNetwork($id)->find('network');
        if ($this->Languages->deleteNetwork($language)) {
            $this->Flash->success(__('The language has been deleted.'));
        } else {
            $this->Flash->error(__('The language could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
