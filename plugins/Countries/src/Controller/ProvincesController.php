<?php

namespace Countries\Controller;

use Countries\Controller\AppController;
use Cake\Event\Event;
use Cake\View\HelperRegistry;
use Cake\View\View;

/**
 * Provinces Controller
 *
 * @property \Countries\Model\Table\ProvincesTable $Provinces
 */
class ProvincesController extends AppController {

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function index() {
        $helpers = new HelperRegistry(new View());
        $this->Form = $helpers->load('Form', []);

        $return = ['status' => false, 'data' => []];
        $provinces = $this->Provinces->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['country_id' => $this->request->data['country_id']]);
        $return = [
            'status' => true,
            'data' => $this->Form->input('province_id', ['type' => 'select', 'label' => false, 'options' => $provinces, 'templates' => ['inputContainer' => '{{content}}']])
        ];
        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }

}
