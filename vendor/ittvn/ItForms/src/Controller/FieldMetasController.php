<?php
namespace ItForms\Controller;

use ItForms\Controller\AppController;
 
/**
 * FieldMetas Controller
 *
 * @property \ItForms\Model\Table\FieldMetasTable $FieldMetas
 */
class FieldMetasController extends AppController
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
    
            $query = $this->FieldMetas->find();            
                $query = $query->contain(['Fields']);
                $this->set('fieldMetas', $this->paginate($query));
            $this->set('_serialize', ['fieldMetas']);
    
    }

    /**
     * View method
     *
     * @param string|null $id Field Meta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fieldMeta = $this->FieldMetas->get($id, [
            'contain' => ['Fields']
        ]);
        $this->set('fieldMeta', $fieldMeta);
        $this->set('_serialize', ['fieldMeta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fieldMeta = $this->FieldMetas->newEntity();
        if ($this->request->is('post')) {
            $fieldMeta = $this->FieldMetas->patchEntity($fieldMeta, $this->request->data);
            if ($this->FieldMetas->save($fieldMeta)) {
                $this->Flash->success(__('The field meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The field meta could not be saved. Please, try again.'));
            }
        }
        $fields = $this->FieldMetas->Fields->find('list', ['limit' => 200]);
        $this->set(compact('fieldMeta', 'fields'));
        $this->set('_serialize', ['fieldMeta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Field Meta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fieldMeta = $this->FieldMetas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fieldMeta = $this->FieldMetas->patchEntity($fieldMeta, $this->request->data);
            if ($this->FieldMetas->save($fieldMeta)) {
                $this->Flash->success(__('The field meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The field meta could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->FieldMetas,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $fields = $this->FieldMetas->Fields->find('list', ['limit' => 200]);
        $this->set(compact('fieldMeta', 'fields'));
        $this->set('_serialize', ['fieldMeta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Field Meta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fieldMeta = $this->FieldMetas->get($id);
        if ($this->FieldMetas->delete($fieldMeta)) {
            $this->Flash->success(__('The field meta has been deleted.'));
        } else {
            $this->Flash->error(__('The field meta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
