<?php

namespace Blocks\Controller\Admin;

use Blocks\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Blocks Controller
 *
 * @property \Blocks\Model\Table\BlocksTable $Blocks
 */
class BlocksController extends AppController {

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
        $blocks = [];
        if (Configure::check('Blocks')) {
            $blocks = Configure::read('Blocks');
        }
        if (!empty($blocks)) {
            $default_lang =  ini_get('intl.default_locale');
            //pr($default_lang); die();
            //$this->Blocks->locale($default_lang);
            $blocks = $this->Blocks->find()
                    ->find('network')
                    ->where(['slug IN' => $blocks]);
        }
        
        $this->set('blocks', $blocks);
        $this->set('_serialize', ['blocks']);
    }

    /**
     * View method
     *
     * @param string|null $id Block id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $block = $this->Blocks->getNetwork($id, [
                    'contain' => []
                ]);
        $this->set('block', $block);
        $this->set('_serialize', ['block']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $message = ['success' => false, 'message' => ''];
        $block = $this->Blocks->newEntity();
        if ($this->request->is('post')) {
            $block = $this->Blocks->patchEntity($block, $this->request->data);
            if ($this->Blocks->saveNetwork($block)) {
                $message['message'] = __('The block has been saved.');
                $message['success'] = true;
            } else {
                $message['message'] = __('The block could not be saved. Please, try again.');
            }
        }
        echo json_encode($message);
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Block id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $block = $this->Blocks->getNetwork($id, [
                    'contain' => []
                ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $block = $this->Blocks->patchEntity($block, $this->request->data);
            if ($this->Blocks->saveNetwork($block)) {
                $this->Flash->success(__('The block has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The block could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('block'));
        $this->set('_serialize', ['block']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Block id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete() {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);
        $block = $this->Blocks->getNetwork($this->request->data['id']);
        if ($this->Blocks->deleteNetwork($block)) {
            //$this->Flash->success(__('The block has been deleted.'));
        } else {
            //$this->Flash->error(__('The block could not be deleted. Please, try again.'));
        }
    }

    public function module($name = null) {
        $this->viewBuilder()->layout(false);
        $module = base64_decode($name);
        $this->set(compact('module'));
    }

    public function saveModule($block_id = null, $module = null, $module_id = null) {
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $module = base64_decode($module);
            $block = $this->Blocks->getNetwork($block_id);
            
            $cells = [];
            if (empty($block->cells)) {
                $cells[] = [
                    'cell' => $module,
                    'params' => $this->request->data ,
                ];
            } else {
                $cells = json_decode($block->cells, true);
                //pr($cells); 
                if ($module_id == 'null' || $module_id == null) {
                    $cells[] = [
                        'cell' => $module,
                        'params' => $this->request->data ,
                    ];
                } else {
                    $cells[$module_id] = [
                        'cell' => $module,
                        'params' => $this->request->data ,
                    ];
                }
            }
            
            $block->cells = json_encode($cells);            
            $this->Blocks->saveNetwork($block);
        }
    }

    public function orderModule($block_id = null) {
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $start = $this->request->data['start'];
            $end = $this->request->data['end'];
            echo 'start: ' . $start . '  end:' . $end;
            $block = $this->Blocks->getNetwork($block_id);
            if (!empty($block->cells)) {
                $cells = json_decode($block->cells, true);
                if ($start <= $end) {
                    $cell_start = $cells[$start];
                    $start_for = $start + 1;
                    for ($i = $start_for; $i <= $end; $i++) {
                        $cells[$i - 1] = $cells[$i];
                    }
                    $cells[$end] = $cell_start;
                } else {
                    $cell_end = $cells[$start];
                    $start_for = $start;
                    for ($i = $start_for; $i >= $end; $i--) {
                        $cells[$i] = $cells[$i - 1];
                    }
                    $cells[$end] = $cell_end;
                }
                $block->cells = json_encode($cells);
            }
            $this->Blocks->saveNetwork($block);
        }
    }

    public function deleteModule($block_id = null) {
        $this->autoRender = false;

        $this->request->allowMethod(['post', 'delete']);
        $block = $this->Blocks->getNetwork($block_id);
        $cells = json_decode($block->cells, true);
        if (isset($cells[$this->request->data['cell']])) {
            unset($cells[$this->request->data['cell']]);

            if (count($cells) > 0) {
                $cell_tmp = [];
                foreach ($cells as $cell) {
                    $cell_tmp[] = $cell;
                }
                $cells = $cell_tmp;
            }
            $block->cells = json_encode($cells);
            $this->Blocks->saveNetwork($block);
        }
    }

}
