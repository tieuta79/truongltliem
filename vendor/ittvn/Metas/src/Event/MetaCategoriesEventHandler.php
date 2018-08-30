<?php

namespace Metas\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Metas\Utility\Metas;
use Cake\ORM\TableRegistry;

class MetaCategoriesEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.MetaCategories.Tables.SelectBoxAction' => 'addFilterSelects',
            'Admin.Tables.MetaCategories.row' => 'addRow',
            'Admin.Views.MetaCategories' => 'view'
        ];
    }

    public function addFilterSelects(Event $event) {
        $filterSelects = $event->subject()['filterSelects'];
        if (!empty($event->result)) {
            $filterSelects = $event->result;
        }
        $filterSelects['MetaTypes'] = [
            'label' => 'Content Type',
            'name' => 'meta_type_id',
            'fields' => ['id', 'name']
        ];
        return $filterSelects;
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
                case 'meta_type_id':
                    $metaType = TableRegistry::get('Metas.MetaTypes')->findById($row->{$field})->find('network')->select('name')->first();
                    $result[$key] = $metaType->name;
                    break;                    
                case 'created':
                    $result[$key] = $helper->format($row->{$field}, 'timeago');
                    break;
            }
        }

        return $result;
    }

    public function formMain(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];

        if (!empty($event->result)) {
            $blocks = $event->result;
        }

        foreach ($blocks as $kb => $block) {
            foreach ($block as $kf => $field) {
                if (!empty($kf) && $kf == 'avatar' && !empty($viewVars['user']->avatar)) {
                    $avatar = $helper->Html->image($viewVars['user']->avatar, ['width' => 100, 'class' => 'img-circle img-thumbnail']);
                    $blocks[$kb][$kf]['templates']['inputContainer'] = '<div class="form-group {{type}}{{required}}">{{content}} <br />' . $avatar . '</div>';
                }
            }
        }
        
        // Add Extra Fields
        $metas = (new Metas())->parseform();

        if (count($metas) > 0) {
            $metas['label'] = 'Extra Fields';
            $blocks['extra_fields'] = $metas;
        }        
        //End add extra fields
        
        return $blocks;
    }

    public function view(Event $event) {
        $fields = $event->subject()['fields'];
        $views = $event->subject()['views'];
        $helper = $event->subject()['helper'];

        foreach ($fields as $key => $field) {
            switch ($key) {
                case 'meta_type_id':
                    $fields[$key]['value'] = $helper->view($field['label'], $views->meta_type->name);
                    break;
                default:
                    break;
            }
        }
        return $fields;
    }

}
