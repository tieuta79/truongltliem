<?php

namespace Countries\Controller;

use Countries\Controller\AppController;
use Cake\View\HelperRegistry;
use Cake\View\View;

/**
 * Wards Controller
 *
 * @property \Countries\Model\Table\WardsTable $Wards
 */
class WardsController extends AppController {

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
        $helpers = new HelperRegistry(new View());
        $this->Form = $helpers->load('Form', []);

        $return = ['status' => false, 'data' => []];
        $wards = $this->Wards->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['city_id' => $this->request->data['city_id']]);
        $return = [
            'status' => true,
            'data' => $this->Form->input('ward_id', ['type' => 'select', 'label' => false, 'options' => $wards, 'templates' => ['inputContainer' => '{{content}}']])
        ];
        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }

}
