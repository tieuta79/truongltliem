<?php

namespace Ittvn\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;
use Cake\Core\App;
use Cake\Utility\Inflector;
use Cake\View\HelperRegistry;
use Cake\View\View;
use Cake\Event\EventManager;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;

class DataTableComponent extends Component {

    private $plugin = false;
    public $relation = false;
    public $associated = false;
    public $no_checkbox = false;
    public $no_action = false;

    public function initialize(array $config = []) {
        if (isset($this->request->plugin) && !empty($this->request->plugin)) {
            $this->plugin = $this->request->plugin;
        }
    }

    public function startup(Event $event) {
        
    }

    public function table($model = null, $query, $tableParams) {

        if (isset($this->request->data['draw']) && !empty($this->request->data['draw'])) {
            if (isset($tableParams['trash'])) {
                $query = $query->where([$model . '.delete' => $tableParams['trash']]);
            }

            $count = $query->count();

            $rows = $query
                    //->where([$model . '.delete' => $tableParams['trash']])
                    ->offset($this->request->data('start'))
                    ->limit($this->request->data('length'))
                    ->order($tableParams['order']);

            $helpers = new HelperRegistry(new View());
            $adminHelper = $helpers->load('Templates.Admin', []);
            $data = [];
            $i = 0;
            foreach ($rows as $row) {
                $data[$i] = $this->__row($model, $row, $tableParams['cols'], $adminHelper);
                $i++;
            }

            $return = [
                'draw' => $this->request->data('draw'),
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ];

            $this->_registry->getController()->set('return', $return);
            $this->_registry->getController()->set('_serialize', 'return');
        }
    }

    public function tableParams($model = null) {
        $return = [
            'trash' => 0,
            'cols' => [],
            'search' => [],
            'order' => []
        ];
        if (isset($this->request->data['draw']) && !empty($this->request->data['draw'])) {
            $return['trash'] = 0;
            if ($this->request->query('trash')) {
                $return['trash'] = $this->request->query('trash');
            }

            //Search table
            foreach ($this->request->data['columns'] as $column) {
                $return['cols'][] = $column['name'];
                if ($column['searchable'] == true && !empty($column['search']['value'])) {
                    $return['search'][$column['name']] = $column['search']['value'];
                }
            }

            if (!empty($this->request->data['search']['value'])) {
                $return['search']['q'] = $this->request->data['search']['value'];
            }

            $return['search']['trash'] = $return['trash'];

            //End Search table            
            //Order table
            if (isset($this->request->data['order']) && count($this->request->data['order']) > 0) {
                foreach ($this->request->data['order'] as $order) {
                    if ($return['cols'][$order['column']] == 'checkbox') {
                        $return['order'][$model . '.id'] = 'desc';
                    } else {
                        if(strpos($return['cols'][$order['column']], '.')==true){
                            $return['order'][$return['cols'][$order['column']]] = $order['dir'];
                        }else{
                            $return['order'][$model . '.' . $return['cols'][$order['column']]] = $order['dir'];
                        }
                    }
                }
            }
            //End Order table            
        }
        return $return;
    }

    private function __row($model, $row, $table_header, $adminHelper) {
        $return = [];
        if ($this->no_checkbox == false) {
            $return[] = $adminHelper->tableRowCheckbox($row->id, false);
        }

        $event = $this->__dispatchEvent('Admin.Tables.row', ['row' => $row, 'header' => $table_header, 'helper' => $adminHelper]);
        if (!empty($event->result)) {
            $return = Hash::merge($return, $event->result);
        }

        $event = $this->__dispatchEvent('Admin.Tables.' . $model . '.row', ['data' => $return, 'row' => $row, 'header' => $table_header, 'helper' => $adminHelper]);
        if (!empty($event->result)) {
            $return = $event->result;
        }
        if ($this->no_action == false) {
            $return[] = $this->__rowAction($model, $row, $adminHelper);
        }

        return $return;
    }

    private function __rowAction($model, $row, $adminHelper) {
        $return = '';
        $action = [];
        $action['Edit'] = $adminHelper->Html->link(
                '<i class="fa fa-pencil-square-o"></i>', ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'edit', $row->id], ['escape' => false, 'class' => 'btn btn-success btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit')]
        );

        $action['Delete'] = $adminHelper->Form->postLink(
                '<i class="fa fa-trash-o"></i>', ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'delete', $row->id], ['escape' => false, 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $row->id)]
        );

        $action['View'] = $adminHelper->Html->link(
                '<i class="fa fa-arrows-alt"></i>', ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'view', $row->id], ['escape' => false, 'class' => 'btn btn-info btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'View')]
        );

        if ($this->relation == true) {
            $event_action = $this->__dispatchEvent('Admin.Tables.relation.rowAction', ['action' => $action, 'row' => $row, 'helper' => $adminHelper]);
            if (!$event_action->isStopped()) {
                if (!empty($event_action->result)) {
                    $return = str_replace('{{action}}', (count($event_action->result) > 0 ? implode('', $event_action->result) : ''), '<div class="btn-group">{{action}}</div>');
                } else {
                    $return = str_replace('{{action}}', (count($action) > 0 ? implode('', $action) : ''), '<div class="btn-group">{{action}}</div>');
                }
            } else {
                $return = '';
            }
        } else if ($this->associated == true) {
            $event_action = $this->__dispatchEvent('Admin.Tables.associated.rowAction', ['action' => $action, 'row' => $row, 'helper' => $adminHelper]);
            if (!$event_action->isStopped()) {
                if (!empty($event_action->result)) {
                    $return = str_replace('{{action}}', (count($event_action->result) > 0 ? implode('', $event_action->result) : ''), '<div class="btn-group">{{action}}</div>');
                } else {
                    $return = str_replace('{{action}}', (count($action) > 0 ? implode('', $action) : ''), '<div class="btn-group">{{action}}</div>');
                }
            } else {
                $return = '';
            }
        } else {
            $event_action = $this->__dispatchEvent('Admin.Tables.' . $model . '.rowAction', ['action' => $action, 'row' => $row, 'helper' => $adminHelper]);
            if (!$event_action->isStopped()) {
                if (!empty($event_action->result)) {
                    $action = $event_action->result;
                }
            } else {
                $action = [];
            }

            $event_afterAction = $this->__dispatchEvent('Admin.Tables.afterRowAction', ['action' => $action, 'row' => $row, 'helper' => $adminHelper]);
            if (!$event_afterAction->isStopped()) {
                if (!empty($event_afterAction->result)) {
                    $return = str_replace('{{action}}', (count($event_afterAction->result) > 0 ? implode('', $event_afterAction->result) : ''), '<div class="btn-group">{{action}}</div>');
                } else {
                    $return = str_replace('{{action}}', (count($action) > 0 ? implode('', $action) : ''), '<div class="btn-group">{{action}}</div>');
                }
            } else {
                $return = '';
            }
        }

        return $return;
    }

    private function __dispatchEvent($event, $data = []) {
        $eventManager = new EventManager();
        return $eventManager->dispatch(new Event($event, $data));
    }

}
