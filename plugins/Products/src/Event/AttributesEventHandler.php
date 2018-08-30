<?php

namespace Products\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Ittvn\Utility\System;

class AttributesEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [            
            'Admin.Tables.Attributes.row' => 'addRow',
            //'Admin.Forms.Attributes.sidebar' => 'form',
            'Admin.Views.Attributes' => 'view'
        ];
    }

    public function addRow(Event $event) {
        $headers = $event->subject()['header'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];

        $result = $event->subject()['data'];
        if (!empty($event->result)) {
            $result = $event->result;
        }

        foreach ($headers as $key => $field) {
            switch ($field) {
                case 'model':
                    $extraFields = (new System())->modelsExtraFields();
                    $result[$key] = $extraFields[$row->model];
                    break;
                case 'options':
                    if (!empty($row->options)) {
                        $options = json_decode($row->options, true);
                        if (count($options) > 0) {
                            $options = Hash::combine($options, '{n}.key', ['%s = %s', '{n}.key', '{n}.value']);
                            $result[$key] = implode('<br />', $options);
                        } else {
                            $result[$key] = '';
                        }
                    } else {
                        $result[$key] = '';
                    }
                    break;
                case 'name':
                    $result[$key] = $helper->Html->link($row->name, ['plugin' => 'Products', 'controller' => 'Attributes', 'action' => 'edit', $row->id], ['data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit') . ': ' . $row->name]);
                    break;
                case 'status':
                    $result[$key] = $row->status == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                    break;
            }
        }
        return $result;
    }

    public function view(Event $event) {
        $fields = $event->subject()['fields'];
        $views = $event->subject()['views'];
        $helper = $event->subject()['helper'];

        foreach ($fields as $key => $field) {
            switch ($key) {
                case 'status':
                    $fields[$key]['value'] = $helper->view($field['label'], ($views->status==1?'<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'));
                    break;
                case 'options':
                    if (!empty($views->options)) {
                        $options = json_decode($views->options, true);
                        if (count($options) > 0) {
                            $options = Hash::combine($options, '{n}.key', ['%s = %s', '{n}.key', '{n}.value']);
                            $fields[$key]['value'] = $helper->view($field['label'],implode('<br />', $options));
                        }
                    }                    
                    break;
                default:
                    break;
            }
        }
        return $fields;
    }

}
