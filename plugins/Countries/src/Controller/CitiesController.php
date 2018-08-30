<?php

namespace Countries\Controller;

use Countries\Controller\AppController;
use Cake\View\HelperRegistry;
use Cake\View\View;
/**
 * Cities Controller
 *
 * @property \Countries\Model\Table\CitiesTable $Cities
 */
class CitiesController extends AppController {

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
        $cities = $this->Cities->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['province_id' => $this->request->data['province_id']]);
        $return = [
            'status' => true,
            'data' => $this->Form->input('city_id', ['type' => 'select', 'label' => false, 'options' => $cities, 'templates' => ['inputContainer' => '{{content}}']])
        ];
        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }
}
