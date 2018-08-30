<?php

namespace Ittvn\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\View;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Request;
use cake\Network\Response;
use Cake\Event\EventManager;
use Cake\ORM\TableRegistry;
use Ittvn\Utility\System;


class ModulesCell extends Cell {

    protected $_validCellOptions = [];

    public function __construct(Request $request = null, Response $response = null, EventManager $eventManager = null, array $cellOptions = array()) {
        parent::__construct($request, $response, $eventManager, $cellOptions);
    }

    public function html($params = [], $form = true) {
        $Systems = new System();
        //pr($Systems->getlanguages(true)); die();
        $languages = TableRegistry::get('Extensions.Languages')->find('list', ['keyField' => 'code', 'valueField' => 'name'])->find('network')->where(['status' => 1]);
        $this->set('languages', $languages);
        $this->set('data', $params);
    }
    
    public function counter($params = [], $form = true) {
        $this->set('data', $params);
    }    

    public function search($params = [], $form = true) {
        $languages = TableRegistry::get('Extensions.Languages')->find('list', ['keyField' => 'code', 'valueField' => 'name'])->find('network')->where(['status' => 1]);
        $this->set('languages', $languages);
        $this->set('data', $params);
    }

}
