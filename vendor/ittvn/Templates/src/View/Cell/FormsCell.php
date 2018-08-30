<?php

namespace Templates\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\HelperRegistry;
use Cake\View\View;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * Tables cell
 */
class FormsCell extends Cell {

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
        //pr($this->request);die();
    }

    public function form($data = null, $model = null) {
        $associations = $this->__findBelongsToMany(['belongsToMany' => []]);
        
        //$associations = Hash::extract($associations, 'belongsToMany.{n}.alias');
        //pr($associations);die();
        //pr($associations);die();
        $this->viewVars = Hash::merge($this->viewVars, $data);
        $this->set('positionMain', $this->__formPositionMain($model));
        $this->set('positionSidebar', $this->__formPositionSidebar($model));
        if (count($associations['belongsToMany']) > 0 && ($this->request->action=='addRelation' || $this->request->action=='editRelation' || $this->request->action == 'addAssociated' || $this->request->action == 'editAssociated') && $this->request->plugin!='Contents') {
            $relation = [];
            foreach($associations['belongsToMany'] as  $k=>$belongsToMany){
                if($belongsToMany['alias']==$this->request->params['pass'][0]){
                    $relation['belongsToMany'][] = $belongsToMany;
                    $associations = $relation;
                    break;
                }
            }            
            $this->set('frmVariable', Inflector::variable(Inflector::singularize($this->request->params['pass'][0])));
        } else {
            $this->set('frmVariable', Inflector::variable($this->_singularize));
        }
        $this->set('belongsToMany', $associations['belongsToMany']);
    }

    private function __formPositionMain($model = null) {
        $model = $this->__getModelName($model);
        $positionMain = Configure::read('Admin.Forms.' . $model . '.main');
        $event = $this->eventManager()->dispatch(new Event('Admin.Forms.' . $model . '.main', ['blocks' => $positionMain, 'helper' => $this->_adminHelper, 'viewVars' => $this->viewVars]));
        if (!empty($event->result)) {
            $positionMain = $event->result;
        }
        return $positionMain;
    }

    private function __formPositionSidebar($model = null) {
        $model = $this->__getModelName($model);
        $positionSidebar = Configure::read('Admin.Forms.' . $model . '.sidebar');
        $event = $this->eventManager()->dispatch(new Event('Admin.Forms.' . $model . '.sidebar', ['blocks' => $positionSidebar, 'helper' => $this->_adminHelper, 'viewVars' => $this->viewVars]));
        if (!empty($event->result)) {
            $positionSidebar = $event->result;
        }        
        return $positionSidebar;
    }

    private function __getModelName($model = null) {
        if (empty($model)) {
            $model = $this->_controller;
        }
        return $model;
    }

    private function __findBelongsToMany($associations) {
        $schema = $this->_model->schema();
        $tableName = $schema->name();
        $foreignKey = $this->__modelKey($tableName);

        $tables = $this->__getAllTables();
        foreach ($tables as $otherTable) {
            $assocTable = null;
            $offset = strpos($otherTable, $tableName . '_');
            $otherOffset = strpos($otherTable, '_' . $tableName);

            if ($offset !== false) {
                $assocTable = substr($otherTable, strlen($tableName . '_'));
            } elseif ($otherOffset !== false) {
                $assocTable = substr($otherTable, 0, $otherOffset);
            }
            if ($assocTable && in_array($assocTable, $tables)) {
                $habtmName = Inflector::camelize($assocTable);
                $assoc = [
                    'alias' => $habtmName,
                    'foreignKey' => $foreignKey,
                    'targetForeignKey' => $this->__modelKey($habtmName),
                    'joinTable' => $otherTable
                ];
                if ($assoc && $this->_plugin) {
                    $assoc['className'] = $this->_plugin . '.' . $assoc['alias'];
                }

                $assoc['schema'] = $this->_model->{$assoc['alias']}->schema();

                $associations['belongsToMany'][] = $assoc;
            }
        }
        return $associations;
    }

    private function __modelKey($name) {
        list(, $name) = pluginSplit($name);
        return Inflector::underscore(Inflector::singularize($name)) . '_id';
    }

    private function __getAllTables() {
        $db = ConnectionManager::get('default');
        if (!method_exists($db, 'schemaCollection')) {
            return [];
        }
        $schema = $db->schemaCollection();
        $tables = $schema->listTables();
        if (empty($tables)) {
            return [];
        }
        sort($tables);
        return $tables;
    }

}
