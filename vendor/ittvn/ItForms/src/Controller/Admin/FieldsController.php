<?php
namespace ItForms\Controller\Admin;

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
    
    if ($this->request->is('post')) {
        $tableParams = $this->DataTable->tableParams('Fields');
        if (count($tableParams['search']) > 0) {
            $query = $this->Fields->find('search', $this->Fields->filterParams($tableParams['search']));
        } else {
            $query = $this->Fields->find();
        }
                $query->contain(['Forms']);
                $this->DataTable->table('Fields', $query, $tableParams);
    }
    
    }
    public function indexFields($slug = null)
    {       
        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Fields');
            if (count($tableParams['search']) > 0) {
                $query = $this->Fields->find('search', $this->Fields->filterParams($tableParams['search']));                
            } else {
                $query = $this->Fields->find();
            }

            $query->contain(['Forms']);
            if (!empty($slug)) {
                $query->where(['Forms.slug' => $slug]);
            }
            $query->find('network');
            $this->DataTable->table('Fields', $query, $tableParams);
        }
        $this->loadModel('ItForms.Forms');
        $form = $this->Forms->find()->find('network')->where(['slug'=>$slug])->first();
        $this->set(compact('slug','form'));
    
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
    public function add($slug = null) {
        $field = $this->Fields->newEntity();
        if ($this->request->is('post')) {
            $forms = $this->Fields->Forms->find()->find('network')->where(['slug' => $slug])->select(['id']);
            $this->request->data['form_id'] = $forms->id;
            $field = $this->Fields->patchEntity($field, $this->request->data);
            if ($this->Fields->saveNetwork($field)) {
                $this->Flash->success(__('The field has been saved.'));
                return $this->redirect(['action' => 'index', $slug]);
            } else {
                $this->Flash->error(__('The field could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('field'));
        $this->set('_serialize', ['field']);
    }

    public function addField($slug = null)
    {
        $field = $this->Fields->newEntity();
        $this->loadModel('ItForms.Forms');
        if ($this->request->is('post')) {            
            $forms = $this->Forms->find()->find('network')->where(['slug' => $slug])->select(['id'])->first();            
            $this->request->data['form_id'] = $forms->id;
            $field = $this->Fields->patchEntity($field, $this->request->data);
            if ($this->Fields->saveNetwork($field)) {
                $this->Flash->success(__('The field has been saved.'));
                return $this->redirect(['action' => 'indexFields',$slug]);
            } else {
                $this->Flash->error(__('The field could not be saved. Please, try again.'));
            }
        }        
        $this->set(compact('field'));
        $this->set('_serialize', ['field']);
    }
    
    /**
     * Edit method
     *
     * @param string|null $id Field id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $slug = null)
    {
        $field = $this->Fields->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $field = $this->Fields->patchEntity($field, $this->request->data);
            if ($this->Fields->save($field)) {
                $this->Flash->success(__('The field has been saved.'));
                return $this->redirect(['action' => 'indexFields', $slug]);
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
    public function trash($id = null, $slug_form = null)
    {        
        $this->request->allowMethod(['post', 'delete']);
        $field = $this->Fields->get($id);
        if ($this->Fields->delete($field)) {
            $this->Flash->success(__('The field has been deleted.'));
        } else {
            $this->Flash->error(__('The field could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'indexFields', $slug_form]);
    }
    
    public function delete($id = null, $slug_form = null)
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