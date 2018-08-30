<?php
namespace ItForms\Controller;

use ItForms\Controller\AppController;
 
/**
 * Fields Controller
 *
 * @property \ItForms\Model\Table\FieldsTable $Fields
 */
class FieldsController extends AppController
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
    
            $query = $this->Fields->find();            
                $query = $query->contain(['Forms']);
                $this->set('fields', $this->paginate($query));
            $this->set('_serialize', ['fields']);
    
    }

    /**
     * View method
     *
     * @param string|null $id Field id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $field = $this->Fields->get($id, [
            'contain' => ['Forms', 'FieldMetas']
        ]);
        $this->set('field', $field);
        $this->set('_serialize', ['field']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $field = $this->Fields->newEntity();
        if ($this->request->is('post')) {
            $field = $this->Fields->patchEntity($field, $this->request->data);
            if ($this->Fields->save($field)) {
                $this->Flash->success(__('The field has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The field could not be saved. Please, try again.'));
            }
        }
        $forms = $this->Fields->Forms->find('list', ['limit' => 200]);
        $this->set(compact('field', 'forms'));
        $this->set('_serialize', ['field']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Field id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $field = $this->Fields->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $field = $this->Fields->patchEntity($field, $this->request->data);
            if ($this->Fields->save($field)) {
                $this->Flash->success(__('The field has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The field could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Fields,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $forms = $this->Fields->Forms->find('list', ['limit' => 200]);
        $this->set(compact('field', 'forms'));
        $this->set('_serialize', ['field']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Field id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $field = $this->Fields->get($id);
        if ($this->Fields->delete($field)) {
            $this->Flash->success(__('The field has been deleted.'));
        } else {
            $this->Flash->error(__('The field could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
