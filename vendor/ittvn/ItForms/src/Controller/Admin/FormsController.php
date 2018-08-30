<?php
namespace ItForms\Controller\Admin;

use ItForms\Controller\AppController;
use Cake\Utility\Hash;
/**
 * Forms Controller
 *
 * @property \ItForms\Model\Table\FormsTable $Forms
 */
class FormsController extends AppController
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
        $tableParams = $this->DataTable->tableParams('Forms');
        if (count($tableParams['search']) > 0) {
            $query = $this->Forms->find('search', $this->Forms->filterParams($tableParams['search']));
        } else {
            $query = $this->Forms->find();
        }
                $this->DataTable->table('Forms', $query, $tableParams);
    }
    
    }

    /**
     * View method
     *
     * @param string|null $id Form id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $form = $this->Forms->get($id, [
            'contain' => ['Fields']
        ]);
        $this->set('form', $form);
        $this->set('_serialize', ['form']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $form = $this->Forms->newEntity();
        if ($this->request->is('post')) {
            $form = $this->Forms->patchEntity($form, $this->request->data);
            if ($this->Forms->save($form)) {
                $this->Flash->success(__('The form has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The form could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('form'));
        $this->set('_serialize', ['form']);
    }
    
    public function htmlform(){     
        $this->loadModel('ItForms.FieldMetas');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inputfist = array_keys($this->request->data['form']);
            $count = $this->FieldMetas->find()->where(['field_id' => $inputfist[0]])->count();
            $datas = [];
            foreach ($this->request->data['form'] as $key => $data) {
                $datas[] = [
                    'value' => $data['value'],
                    'field_id' => $key
                ];
            }
            $datas = Hash::insert($datas, '{n}.key',++$count);
            if(count($datas)>0){
                $fieldMeta = $this->FieldMetas->newEntities($datas);
                $this->FieldMetas->saveManyNetwork($fieldMeta);
            }
           
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Form id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $form = $this->Forms->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $form = $this->Forms->patchEntity($form, $this->request->data);
            if ($this->Forms->save($form)) {
                $this->Flash->success(__('The form has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The form could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Forms,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $this->set(compact('form'));
        $this->set('_serialize', ['form']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Form id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function trash($id = null)
    {	
        $this->request->allowMethod(['post', 'delete']);       		
        $form = $this->Forms->get($id);
        if ($this->Forms->delete($form)) {
            $this->Flash->success(__('The form has been deleted.'));
        } else {
            $this->Flash->error(__('The form could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $form = $this->Forms->get($id);
        if ($this->Forms->delete($form)) {
            $this->Flash->success(__('The form has been deleted.'));
        } else {
            $this->Flash->error(__('The form could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}