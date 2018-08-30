<?php

namespace Metas\Controller\Admin;

use Metas\Controller\AppController;
use Ittvn\Utility\System;
use Cake\ORM\TableRegistry;
use Settings\Utility\Setting;

/**
 * Metas Controller
 *
 * @property \Metas\Model\Table\MetasTable $Metas
 */
class MetasController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $tableParams = $this->DataTable->tableParams('Metas');
        if (count($tableParams['search']) > 0) {
            $query = $this->Metas->find('search', $this->Metas->filterParams($tableParams['search']));
        } else {
            $query = $this->Metas->find();
        }
        $query->find('network');

        $this->DataTable->table('Metas', $query, $tableParams);
    }

    /**
     * View method
     *
     * @param string|null $id Meta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $meta = $this->Metas->getNetwork($id, [
            'contain' => []
        ]);
        $this->set('meta', $meta);
        $this->set('_serialize', ['meta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $meta = $this->Metas->newEntity();
        if ($this->request->is('post')) {
            $meta = $this->Metas->patchEntity($meta, $this->request->data);
            if ($this->Metas->saveNetwork($meta)) {
                $this->Flash->success(__('The meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The meta could not be saved. Please, try again.'));
            }
        }
        $models = (new System())->modelsExtraFields();
        $this->set(compact('meta', 'models'));
        $this->set('_serialize', ['meta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Meta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $meta = $this->Metas->getNetwork($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $meta = $this->Metas->patchEntity($meta, $this->request->data);
            if ($this->Metas->saveNetwork($meta)) {
                $this->Flash->success(__('The meta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The meta could not be saved. Please, try again.'));
            }
        }
        $models = (new System())->modelsExtraFields();
        $this->set(compact('meta', 'models'));
        $this->set('_serialize', ['meta']);
    }
    
    public function editLanguage($id = null) {
        $setting = new Setting();
        $fileds = json_decode($setting->getOption('Translation.ExtraFields'),true);
        if(!empty($fileds)){
            if ($this->request->is(['patch', 'post', 'put'])) {
                $this->Metas->locale($this->request->query('lang'));
                foreach ($fileds as $value) {
                    $translate[$value] = $this->request->data[$value];
                }                
                $meta = $this->Metas->newEntity($translate);
                $meta->id = $id;
                if ($this->Metas->saveNetwork($meta)) {
                    $this->Flash->success(__('The meta has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The meta could not be saved. Please, try again.'));
                }
            }else{
                $meta = $this->Metas->getNetwork($id, [
                    'contain' => []
                ]);
                $models = (new System())->modelsExtraFields();
                $this->set(compact('meta', 'models'));
                $this->set('_serialize', ['meta']);
            }
        }
    }
    /**
     * Delete method
     *
     * @param string|null $id Meta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $meta = $this->Metas->getNetwork($id);
        if ($this->Metas->deleteNetwork($meta)) {
            $this->Flash->success(__('The meta has been deleted.'));
        } else {
            $this->Flash->error(__('The meta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function contentTypes() {
        $this->autoRender = false;
        $model = $this->request->data['model'];
        $contentTypes = TableRegistry::get($model)->find('list', ['limit' => 1000])->find('network');
        echo json_encode($contentTypes);
    }

}
