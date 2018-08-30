<?php

namespace Settings\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Ittvn\Utility\System;

class SettingsEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            //'Admin.Metas.Tables.SelectBoxAction' => 'addFilterSelects',
            //'Admin.Tables.Metas.row' => 'addRow',
            //'Admin.Forms.Metas.sidebar' => 'form',
            //'Admin.Views.Metas' => 'view'
        ];
    }

    public function addFilterSelects(Event $event) {

        $filterSelects = $event->subject()['filterSelects'];
        if (!empty($event->result)) {
            $filterSelects = $event->result;
        }
        
        $extraFields = (new System())->modelsExtraFields();

        $filterSelects['model'] = [
            'label' => 'Plugin',
            'name' => 'model',
            'options' => $extraFields
        ];
        return $filterSelects;
    }

    public function addRow(Event $event) {
        $headers = $event->subject()['header'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];

        $result = [];
        if (!empty($event->result)) {
            $result = $event->result;
        }

        foreach ($headers as $field) {
            switch ($field) {
                case 'model':
                    $extraFields = (new System())->modelsExtraFields();
                    $result[$field] = $extraFields[$row->model];
                    break;
                case 'options':
                    if (!empty($row->options)) {
                        $options = json_decode($row->options, true);
                        if (count($options) > 0) {
                            $options = Hash::combine($options, '{n}.key', ['%s = %s', '{n}.key', '{n}.value']);
                            $result[$field] = implode('<br />', $options);
                        } else {
                            $result[$field] = '';
                        }
                    } else {
                        $result[$field] = '';
                    }
                    break;
                case 'name':
                    $result[$field] = $helper->Html->link($row->name, ['plugin' => 'Metas', 'controller' => 'Metas', 'action' => 'edit', $row->id], ['data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit') . ': ' . $row->name]);
                    break;
                case 'status':
                    $result[$field] = $row->status == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                    break;
            }
        }
        return $result;
    }

    public function form(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];

        if (!empty($event->result)) {
            $blocks = $event->result;
        }

        foreach ($blocks as $kb => $block) {
            foreach ($block as $kf => $field) {
                if (!empty($kf) && $kf == 'foreign_key') {
                    $blocks[$kb][$kf]['templates']['inputContainer'] = '<div class="form-group model_get_load_ajax {{type}}{{required}}" value="'.$viewVars['meta']->foreign_key.'">{{content}}</div>';
                }
            }
        }
        return $blocks;        

    }

    public function view(Event $event) {
        $fields = $event->subject()['fields'];
        $views = $event->subject()['views'];
        $helper = $event->subject()['helper'];

        foreach ($fields as $key => $field) {
            switch ($key) {
                case 'model':
                    $extraFields = (new System())->modelsExtraFields();
                    $fields[$key]['value'] = $helper->view($field['label'],$extraFields[$views->model]);                    
                    break;
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
