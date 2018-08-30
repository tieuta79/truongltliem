<?php

namespace ItForms\Controller\Admin;

use ItForms\Controller\AppController;
use Cake\Utility\Hash;
use Cake\Collection\Collection;

/**
 * FieldMetas Controller
 *
 * @property \ItForms\Model\Table\FieldMetasTable $FieldMetas
 */
class FieldMetasController extends AppController {

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
    public function index($slug = null) {
        $tableParams = $this->DataTable->tableParams('FieldMetas');    
        $this->loadModel('ItForms.Fields');
        $this->loadModel('ItForms.Forms');
        $forms = $this->Forms->find()->find('network')->select(['id'])->where(['slug' => $slug])->first();
        
        $listfields = $this->Fields->find('list', ['keyField' => 'id', 'valueField' => 'slug'])->where(['form_id' => $forms->id]);
        $fieldids = [];
        if ($listfields->count() > 0) {
            $fieldids = array_keys($listfields->toArray());
        }
        $listfields = $listfields->toArray();
        $fieldmetas = $this->FieldMetas->find()->select(['id', 'key', 'value', 'field_id'])->where(['field_id IN' => $fieldids, 'delete' => 0])
                ->formatResults(function ($results) use($listfields) {
            $abcs = $results->map(function ($row) use($listfields) {
                $row['id'] = $row->key;
                $field_id = $row->field_id;
                $row->{$listfields[$field_id]} = $row->value;

                unset($row['key']);
                unset($row['value']);
                unset($row['field_id']);

                return $row;
            });

            $ids = (new Collection($abcs))->groupBy('id');

            $ids = (new Collection($ids))->map(function($value, $key) {
                if (count($value) > 1) {
                    foreach ($value as $k => $v) {
                        if ($k == 0) {
                            continue;
                        }

                        $v = $v->toArray();
                        unset($v['id']);
                        $fk = array_keys($v);
                        $value[0][$fk[0]] = $v[$fk[0]];

                        unset($value[$k]);
                    }
                }
                return $value;
            });

            $data = [];
            foreach ($ids as $k => $v) {
                $data[] = $v[0];
            }

            return $data;
        });
        
        $this->DataTable->table('FieldMetas', $fieldmetas, $tableParams);
        
        //$this->set('fieldmetas',$fieldmetas);
    }

    /**
     * View method
     *
     * @param string|null $id Field Meta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
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
    public function add() {
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
    public function edit($id = null) {
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
        $associations = $this->Ittvn->findBelongsToMany($this->FieldMetas, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
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
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $fieldMeta = $this->FieldMetas->get($id);
        if ($this->FieldMetas->delete($fieldMeta)) {
            $this->Flash->success(__('The field meta has been deleted.'));
        } else {
            $this->Flash->error(__('The field meta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function deletefieldm($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $ids = $this->FieldMetas->find()->where(['key' => $id]);
    }

    public function trash($id = null, $slug_form = null) {        
        $this->request->allowMethod(['post']);
        $this->loadModel('ItForms.Forms');
        $forms = $this->Forms->find()->find('network')->contain('Fields')->where(['Forms.slug' => $slug_form])->first();
        $result = Hash::combine($forms->fields, '{n}.id', '{n}.id');
        $ids = $this->FieldMetas->find()->find('network')->select(['id', 'key','field_id'])->where(['field_id IN' => $result,'key' => $id]);        
        foreach ($ids as $idfm) {
            $fieldMeta = $this->FieldMetas->get($idfm->id);
            if (!empty($fieldMeta)) {
                $fieldMeta->delete = 1;
                $this->FieldMetas->saveNetwork($fieldMeta);
            }
            //$this->FieldMetas->delete($fieldMeta);
        }
        return $this->redirect(['action' => 'index', $slug_form]);
    }

}