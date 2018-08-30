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
class TablesCell extends Cell {

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

    public function filter() {
        $showFilter = isset($this->_model->filterTable) ? $this->_model->filterTable : false;
        $this->set('filterOptions', $this->__filterOptionActionTable());
        $this->set('filterSelectBox', $this->__filterSelectBoxActionTable());
        $this->set('showFilter', $showFilter);
    }

    private function __filterOptionActionTable() {
        $options = Configure::read('Settings.Templates.action');
        $event = $this->eventManager()->dispatch(new Event('Cell.Admin.Tables.optionsAction', ['options' => $options]));
        if (!empty($event->result)) {
            $options = $event->result;
        }
        return $options;
    }

    private function __filterSelectBoxActionTable() {
        $filterSelects = [];
        $event = $this->eventManager()->dispatch(new Event('Admin.' . $this->_controller . '.Tables.SelectBoxAction', ['filterSelects' => $filterSelects]));
        if (!$event->isStopped()) {
            if (!empty($event->result)) {
                $filterSelects = $event->result;
            }

            $action_right_selects = [];
            if (count($filterSelects) > 0) {
                foreach ($filterSelects as $model => $filter_table) {
                    $action_right_selects[$filter_table['name']]['label'] = $filter_table['label'];
                    if (isset($filter_table['options'])) {
                        $action_right_selects[$filter_table['name']]['list'] = $filter_table['options'];
                    } else {
                        $action_right_selects[$filter_table['name']]['list'] = $this->_model->{$model}->find('list', [
                            'keyField' => $filter_table['fields'][0],
                            'valueField' => $filter_table['fields'][1]
                        ]);
                    }
                }
            }

            $action_right_selects['limit'] = [
                'label' => 'Paging',
                'list' => Configure::read('Settings.Paging.limit')
            ];
            return $action_right_selects;
        }

        return false;
    }

    private function __getTableHeader($model = null) {
        $header = Configure::read('Admin.Tables.' . $model . '.header');
        $event = $this->eventManager()->dispatch(new Event('Admin.Tables.' . $model . '.header', ['header' => $header]));
        if (!empty($event->result)) {
            $header = $event->result;
        }
        return $header;
    }

    /**
     * Default header method.
     *
     * @return void
     */
    public function header($model = null, $tagBox = 'thead') {
        if (empty($model)) {
            $model = $this->_controller;
        }
        $dataHeaders = $this->__getTableHeader($model);
        $tableHeader = [];
        $tableHeader = $this->_adminHelper->tableHeaderCheckbox();


        $params_paging = $this->_adminHelper->Paginator->params($this->_controller);

        foreach ($dataHeaders as $key => $col) {
            if (!isset($col['label'])) {
                $col['label'] = $key;
            }
            if (!empty($params_paging) && isset($col['sort']) && !empty($col['sort'])) {
                if (is_array($col['sort'])) {
                    $key = $col['sort']['key'];
                }
                if (isset($params_paging['sort']) && $params_paging['sort'] == $key) {
                    if (isset($col['class'])) {
                        if ($col['class'] == 'sorting') {
                            $col['class'] = 'sorting_' . $params_paging['direction'];
                        } else {
                            $col['class'] .= ' sorting_' . $params_paging['direction'];
                        }
                    } else {
                        $col['class'] = 'sorting_' . $params_paging['direction'];
                    }
                } else {
                    if (isset($col['class'])) {
                        $col['class'] .= ' sorting';
                    } else {
                        $col['class'] = 'sorting';
                    }
                }
                //$tableHeader[$key][$this->_adminHelper->Paginator->sort($key, __d('ittvn', $col['label']))] = $col;
                $tableHeader[$key][__d('ittvn', $col['label'])] = $col;
            } else {
                if (isset($col['class'])) {
                    $col['class'] .= ' sorting';
                } else {
                    $col['class'] = 'sorting';
                }
                $tableHeader[$key][__d('ittvn', $col['label'])] = $col;
            }
            $tableHeader[$key][__d('ittvn', $col['label'])]['name'] = $key;
        }

        $tableHeader = Hash::remove($tableHeader, '{s}.{s}.label');
        $tableHeader = Hash::remove($tableHeader, '{s}.{s}.sort');
        $tableHeader = Hash::remove($tableHeader, '{s}.{s}.format');

        $tableHeader['Action'] = [__d('ittvn', 'Action') => ['name' => 'action', 'data-hide' => 'phone,tablet']];

        $event = $this->eventManager()->dispatch(new Event('Admin.Tables.' . $this->_controller . '.AfterBuildHeader', ['header' => $tableHeader]));
        if (!empty($event->result)) {
            $tableHeader = $event->result;
        }

        $filter = $this->headerFilter($tableHeader);
        $this->set('filter', $filter);
        $this->set('header', $tableHeader);
        $this->set('tag', $tagBox);
    }

    public function headerFilter($header) {
        $filter = [];
        $event = $this->eventManager()->dispatch(new Event('Admin.Tables.filterHeader', ['header' => $header]));
        if (!empty($event->result)) {
            $filter = $event->result;
        }

        $event_filter = $this->eventManager()->dispatch(new Event('Admin.Tables.' . $this->_controller . '.filterHeader', ['filter' => $filter]));
        if (!empty($event_filter->result)) {
            $filter = $event_filter->result;
        }

        return $filter;
    }

    /**
     * Default row method.
     *
     * @return void
     */
    public function rows($model = null, $dataRows = []) {
        if (empty($model)) {
            $model = $this->_controller;
        }

        $tableRows = [];
        $dataHeaders = array_keys($this->__getTableHeader($model));
        foreach ($dataRows as $key => $row) {
            $tableRows[] = $this->_row($row, $dataHeaders, $model);
        }
        $this->set('rows', $tableRows);
    }

    private function _row($row = [], $table_header = [], $model) {
        $tableRow = [];
        $tableRow = $this->_adminHelper->tableRowCheckbox($row->id);

        $event = $this->eventManager()->dispatch(new Event('Admin.Tables.row', ['row' => $row, 'header' => $table_header, 'helper' => $this->_adminHelper]));
        if (!empty($event->result)) {
            $tableRow = Hash::merge($tableRow, $event->result);
        }

        $event = $this->eventManager()->dispatch(new Event('Admin.Tables.' . $model . '.row', ['row' => $row, 'header' => $table_header, 'helper' => $this->_adminHelper]));
        if (!empty($event->result)) {
            $tableRow = Hash::merge($tableRow, $event->result);
        }


        $action = [];
        $action['Edit'] = $this->_adminHelper->Html->link(
                '<i class="fa fa-pencil-square-o"></i>', ['plugin' => $this->_plugin, 'controller' => $this->_controller, 'action' => 'edit', $row->id], ['escape' => false, 'class' => 'btn btn-success btn-sm', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit')]
        );

        $action['Delete'] = $this->_adminHelper->Form->postLink(
                '<i class="fa fa-trash-o"></i>', ['plugin' => $this->_plugin, 'controller' => $this->_controller, 'action' => 'delete', $row->id], ['escape' => false, 'class' => 'btn btn-danger btn-sm', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $row->id)]
        );

        $action['View'] = $this->_adminHelper->Html->link(
                '<i class="fa fa-arrows-alt"></i>', ['plugin' => $this->_plugin, 'controller' => $this->_controller, 'action' => 'view', $row->id], ['escape' => false, 'class' => 'btn btn-info btn-sm', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'View')]
        );

        $event_action = $this->eventManager()->dispatch(new Event('Admin.Tables.' . $model . '.rowAction', ['action' => $action, 'row' => $row, 'helper' => $this->_adminHelper]));
        if (!$event_action->isStopped()) {
            if (!empty($event_action->result)) {
                $action = $event_action->result;
            }
        } else {
            $action = [];
        }

        $event_afterAction = $this->eventManager()->dispatch(new Event('Admin.Tables.afterRowAction', ['action' => $action, 'row' => $row, 'helper' => $this->_adminHelper]));
        if (!$event_afterAction->isStopped()) {
            if (!empty($event_afterAction->result)) {
                $tableRow['Action'] = str_replace('{{action}}', (count($event_afterAction->result) > 0 ? implode('', $event_afterAction->result) : ''), '<div class="btn-group">{{action}}</div>');
            } else {
                $tableRow['Action'] = str_replace('{{action}}', (count($action) > 0 ? implode('', $action) : ''), '<div class="btn-group">{{action}}</div>');
            }
        } else {
            $tableRow['Action'] = '';
        }

        return $tableRow;
    }

    /**
     * Default row method.
     *
     * @return void
     */
    public function action_right_table($action_right_selects = []) {
        if (isset($this->_model->filter_table) && count($this->_model->filter_table) > 0) {
            foreach ($this->_model->filter_table as $model => $filter_table) {
                $action_right_selects[$filter_table['name']]['label'] = $filter_table['label'];
                $action_right_selects[$filter_table['name']]['list'] = $this->_model->{$model}->find('list', [
                    'keyField' => $filter_table['fields'][0],
                    'valueField' => $filter_table['fields'][1]
                ]);
            }
        }
        $this->set('action_right_selects', $action_right_selects);
    }

}
