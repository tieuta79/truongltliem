<?php

namespace Acl\View\Helper;

use Cake\View\Helper;
use Cake\Utility\Hash;
use Cake\View\StringTemplateTrait;
use Cake\I18n\Time;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class AclHelper extends Helper {

    public function __construct(\Cake\View\View $View, array $config = array()) {
        parent::__construct($View, $config);
        $this->Permissions = TableRegistry::get('Acl.Permissions');
    }
    
    public function check($aro, $aco, $action = '*') {
    	//pr($aro);
        return $this->Permissions->check($aro, $aco, $action);
    }

}
