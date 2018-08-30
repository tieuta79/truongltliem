<?php

namespace Templates\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\HelperRegistry;
use Cake\View\View;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Tables cell
 */
class ViewsCell extends Cell {

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];
    protected $_plugin = null;
    protected $_controller = null;
    protected $_action = null;
    protected $_singularize = null;
    protected $_model = null;
    protected $_adminHelper = null;

    public function __construct(\Cake\Network\Request $request = null, \Cake\Network\Response $response = null, \Cake\Event\EventManager $eventManager = null, array $cellOptions = array()) {
        parent::__construct($request, $response, $eventManager, $cellOptions);

        if (isset($request->plugin) && !empty($request->plugin)) {
            $this->_plugin = $request->plugin;
        }
        $this->_controller = $request->controller;
        $this->_action = $request->action;
        $this->_singularize = Inflector::singularize($this->_controller);

        if (!empty($this->_plugin)) {
            $this->_model = $this->loadModel($this->_plugin . '.' . ucfirst($this->_controller));
        } else {
            $this->_model = $this->loadModel(ucfirst($this->_controller));
        }

        $helpers = new HelperRegistry(new View());
        $this->_adminHelper = $helpers->load('Templates.Admin', []);
    }

    /**
     * Default row method.
     *
     * @return void
     */
    public function viewInfo($data) {
        $viewVariable = Inflector::variable($this->_singularize);
        $this->viewVars[$viewVariable] = $data;   
        $model = $this->__getModelName();
        $fields = Configure::read('Admin.Views.'.$model);
        
        $fields = $this->__getDefaultFields($fields, $data);
        $fields = $this->__getFields($model, $fields, $data);
        $this->set('views', $fields);
    }

    private function __getDefaultFields($fields = [], $data = []) {
        $event = $this->eventManager()->dispatch(new Event('Admin.Views', ['views' =>$data, 'fields'=> $fields, 'helper' => $this->_adminHelper]));
        if (!empty($event->result)) {
            $fields = $event->result;
        }
        return $fields;
    }    
    
    private function __getFields($model, $fields = [], $data = []) {
        $return = [];
        $event = $this->eventManager()->dispatch(new Event('Admin.Views.' . $model, ['views' =>$data, 'fields'=> $fields, 'helper' => $this->_adminHelper]));
        if (!empty($event->result)) {
            $return = $event->result;
        }else{
            $return = $fields;
        }
        return $return;
    }

    private function __getModelName($model = null) {
        if (empty($model)) {
            $model = $this->_controller;
        }
        return $model;
    }

}
