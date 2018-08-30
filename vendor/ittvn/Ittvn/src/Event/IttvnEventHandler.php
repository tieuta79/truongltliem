<?php

namespace Ittvn\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Settings\Utility\Setting;

class IttvnEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Cell.Admin.Tables.optionsAction' => ['callable' => 'updateActionTrash', 'priority' => 1],
            'Admin.Tables.row' => ['callable' => 'addRow', 'priority' => 1],
            'Admin.Views' => ['callable' => 'view', 'priority' => 1],
            'Admin.View.setTabs' => ['callable' => 'setTabs', 'priority' => 1],
            'Admin.Tables.afterRowAction' => ['callable' => 'afterRowAction', 'priority' => 100],
            'Admin.Tables.relation.rowAction' => ['callable' => 'relationRowAction', 'priority' => 1],
            'Admin.Tables.associated.rowAction' => ['callable' => 'associatedRowAction', 'priority' => 1],
            'Admin.Tables.filterHeader' => ['callable' => 'filterHeader', 'priority' => 1]
        ];
    }

    public function updateActionTrash(Event $event) {
        $request = Request::createFromGlobals();
        if ($request->query('trash') && $request->query('trash') == 1) {
            if (!empty($event->result)) {
                $options = $event->result;
            } else {
                $options = $event->subject()['options'];
            }
            if (isset($options['trash'])) {
                unset($options['trash']);
            }
            $options['untrash'] = __d('ittvn', 'UnTrash');
            $options['delete'] = __d('ittvn', 'Delete');
            return $options;
        }
    }

    public function afterRowAction(Event $event) {
        $action = $event->subject()['action'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();
        if (!$request->query('trash') || $request->query('trash') == 0) {
            if (isset($action['Delete'])) {
                $action['Delete'] = str_replace(['delete', 'Delete'], ['trash', 'Move to Trash'], $action['Delete']);
            }
        } else {
            unset($action['Edit']);
            unset($action['View']);
            if (isset($action['Delete'])) {
                $action['Delete'] = str_replace('fa-trash-o', 'fa-times', $action['Delete']);
            }
        }
        return $action;
    }

    public function filterHeader(Event $event) {
        $header = $event->subject()['header'];        
        $setting = new Setting();
        $filters = [];
        foreach ($header as $k => $h) {
            if ($k == 'Checkbox' || $k == 'Action') {
                $filters[$k] = '';
            } else {
                foreach ($h as $k1 => $h1) {
                    if (isset($h1['filter']) && $h1['filter'] == 'date') {
                        $id_filter = Inflector::slug($k);
                        $input_html = '<input id="filter-' . $id_filter . '" type="text" placeholder="Filter ' . $k1 . '" class="form-control datepicker" data-type="date" data-dateformat="'.(str_replace(['d','m','Y'], ['dd','mm','yy'], $setting->getOption('Sites.format_date'))).'" />';
                        $input_html .= '<label for="filter-' . $id_filter . '" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter ' . $k1 . '"></label>';
                        $filters[$k][$input_html]['class'] = 'hasinput icon-addon';
                    } else if (isset($h1['filter']) && $h1['filter'] == 'list') {
                        $filters[$k]['<select class="form-control" style="width: 100%;"><option value="">Filter ' . $k1 . '</option></select>']['class'] = 'hasinput';
                    } else {
                        $filters[$k]['<input type="text" class="form-control" rel="tooltip" title="" data-original-title="Filter ' . $k1 . '" placeholder="Filter ' . $k1 . '" />']['class'] = 'hasinput';
                    }
                }
            }
        }
        return $filters;
    }

    public function relationRowAction(Event $event) {
        $subject = $event->subject();
        $action = $subject['action'];
        $request = Router::getRequest();

        $action['Edit'] = $subject['helper']->Html->link(
                '<i class="fa fa-pencil-square-o"></i>', [
            'plugin' => $request->plugin,
            'controller' => $request->controller,
            'action' => 'editRelation',
            $request->params['pass'][0],
            $request->params['pass'][1],
            $subject['row']->id
                ], [
            'escape' => false,
            'class' => 'btn btn-success btn-xs',
            'data-toggle' => 'tooltip',
            'title' => __d('ittvn', 'Edit')
                ]
        );

        $action['Delete'] = $subject['helper']->Form->postLink(
                '<i class="fa fa-trash-o"></i>', [
            'plugin' => $request->plugin,
            'controller' => $request->controller,
            'action' => 'deleteRelation',
            $request->params['pass'][0],
            $request->params['pass'][1],
            $subject['row']->id
                ], [
            'escape' => false,
            'class' => 'btn btn-danger btn-xs',
            'data-toggle' => 'tooltip',
            'title' => __d('ittvn', 'Delete'),
            'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $subject['row']->id)
                ]
        );

        unset($action['View']);
        return $action;
    }

    public function associatedRowAction(Event $event) {
        $subject = $event->subject();
        $action = $subject['action'];
        $request = Router::getRequest();

        $action['Edit'] = $subject['helper']->Html->link(
                '<i class="fa fa-pencil-square-o"></i>', [
            'plugin' => $request->plugin,
            'controller' => $request->controller,
            'action' => 'editAssociated',
            $request->params['pass'][0],
            $request->params['pass'][1],
            $request->params['pass'][2],
            $subject['row']->id
                ], [
            'escape' => false,
            'class' => 'btn btn-success btn-xs',
            'data-toggle' => 'tooltip',
            'title' => __d('ittvn', 'Edit')
                ]
        );

        $action['Delete'] = $subject['helper']->Form->postLink(
                '<i class="fa fa-trash-o"></i>', [
            'plugin' => $request->plugin,
            'controller' => $request->controller,
            'action' => 'deleteAssociated',
            $request->params['pass'][0],
            $request->params['pass'][1],
            $request->params['pass'][2],
            $subject['row']->id
                ], [
            'escape' => false,
            'class' => 'btn btn-danger btn-xs',
            'data-toggle' => 'tooltip',
            'title' => __d('ittvn', 'Delete'),
            'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $subject['row']->id)
                ]
        );

        unset($action['View']);
        return $action;
    }

    /*
      public function addRow(Event $event) {
      $headers = $event->subject()['header'];
      $row = $event->subject()['row'];

      $helper = $event->subject()['helper'];
      $result = [];
      foreach ($headers as $field) {
      if (strpos($field, '_id')) {
      $model_join = str_replace('_id', '', $field);
      if (isset($row->{$model_join})) {
      $display_field = TableRegistry::get(Inflector::camelize(Inflector::pluralize($model_join)))->displayField();
      $result[$field] = $row->{$model_join}->$display_field;
      } else {
      $result[$field] = $row->{$field};
      }
      } else {
      $result[$field] = $row->{$field};
      }
      }
      return $result;
      }
     */

    public function addRow(Event $event) {
        $headers = $event->subject()['header'];
        $row = $event->subject()['row'];
        $setting = new Setting();

        $helper = $event->subject()['helper'];
        $result = [];
        foreach ($headers as $key => $field) {
            if (!in_array($field, ['checkbox', 'action'])) {
                if (isset($row->{$field}) && is_object($row->{$field}) && get_class($row->{$field}) == 'Cake\I18n\Time') {
                    $result[$key] = $row->{$field}->format($setting->getOption('Sites.format_date') . ' ' . $setting->getOption('Sites.format_time'));
                } else {
                    if (strpos($field, '_id')) {
                        $model_join = str_replace('_id', '', $field);
                        if (isset($row->{$model_join})) {
                            $display_field = TableRegistry::get(Inflector::camelize(Inflector::pluralize($model_join)))->displayField();
                            $result[$key] = $row->{$model_join}->$display_field;
                        } else {
                            $result[$key] = $row->{$field};
                        }
                    } else if (strpos($field, '___')) {
                        $fs = explode('___', $field);
                        if (isset($row->{$fs[0]})) {
                            if (isset($row->{$fs[0]}->{$fs[1]})) {
                                $result[$key] = $row->{$fs[0]}->{$fs[1]};
                            } else {
                                $result[$key] = '';
                            }
                        } else {
                            $result[$key] = $row->{$field};
                        }
                    } else {
                        $result[$key] = $row->{$field};
                    }
                }
            }
        }
        return $result;
    }

    public function view(Event $event) {
        $fields = $event->subject()['fields'];
        $views = $event->subject()['views'];
        $helper = $event->subject()['helper'];

        foreach ($fields as $key => $field) {
            if (is_object($views->{$key}) && get_class($views->{$key}) == 'Cake\I18n\Time') {
                if (isset($field['format']) && isset($field['format']['text'])) {
                    $fields[$key]['value'] = $helper->view($field['label'], $views->{$key}->format($field['format']['text']));
                } else {
                    $fields[$key]['value'] = $helper->view($field['label'], $views->{$key});
                }
            } else {
                $fields[$key]['value'] = $helper->view($field['label'], $views->{$key});
            }
        }
        return $fields;
    }

    public function setTabs(Event $event) {
        $data = $event->subject()['data'];
        $tabs = $event->subject()['tabs'];
        $contentTabs = $event->subject()['contentTabs'];

        $result = [
            'tabs' => $tabs,
            'contentTabs' => $contentTabs
        ];
        return $result;
    }

}
