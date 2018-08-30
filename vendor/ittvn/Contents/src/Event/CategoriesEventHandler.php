<?php

namespace Contents\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Ittvn\Utility\System;
use Metas\Utility\Metas;
use Settings\Utility\Setting;
use Ittvn\Utility\Language;

class CategoriesEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            //'Admin.Categories.Tables.SelectBoxAction' => 'addFilterSelects',
            'Admin.Tables.Categories.row' => 'addRow',
            'Admin.Forms.Categories.main' => 'formMain',
            //'Admin.Views.Metas' => 'view',
            'Admin.Tables.Categories.rowAction' => 'rowAction'
        ];
    }

    public function addFilterSelects(Event $event) {

        $filterSelects = $event->subject()['filterSelects'];
        if (!empty($event->result)) {
            $filterSelects = $event->result;
        }

        $filterSelects['ParentCategories'] = [
            'label' => 'Parent Category',
            'name' => 'parent_id',
            'fields' => ['id', 'name']
        ];
        return $filterSelects;
    }

    public function addRow(Event $event) {
        $headers = $event->subject()['header'];              
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        $result = $event->subject()['data'];
        if (!empty($event->result)) {
            $result = $event->result;
        }

        foreach ($headers as $key => $field) {            
            switch ($field) {
                case 'name':
                    if (!empty($row->name)) {
                        $result[$key] = $helper->Html->link($row->name, ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'edit', $row->id, $request->params['pass'][0]]);
                    } else {
                        $result[$key] = '';
                    }
                    break;
                case 'translate':
                    $default_lang =  ini_get('intl.default_locale');
                    //$settings = new Setting();
                    //$settings->getOption('Sites.language_default')
                    //$languages = TableRegistry::get('Extensions.Languages')->find()->find('network')->where(['status' => 1]);
                    if(Language::getLanguages()->count() > 1){
                        $languages = Language::$languages;
                        $i=0;
                        foreach($languages as $language){
                            if($language['code'] != $default_lang){
                                $nameclass = "flag ".$language['class'];
                                $result[$key][$i] = $helper->Html->image("/templates/img/blank.gif", [
                                    "class" => $nameclass,
                                    "alt" => $language['name'],
                                    'url' => ['plugin' => 'Contents','controller' => 'Categories', 'action' => 'edit_language', $row->id, $request->params['pass'][0], 'lang'=>$language['code']]
                                ]);                                
                                $i++;
                            }
                        }
                    }
            }
        }
        return $result;
    }

    function rowAction(Event $event) {
        $action = $event->subject()['action'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        $action['Edit'] = $helper->Html->link(
                '<i class="fa fa-pencil-square-o"></i>', ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'edit', $row->id, $request->params['pass'][0]], ['escape' => false, 'class' => 'btn btn-success btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit')]
        );

        $action['Delete'] = $helper->Form->postLink(
                '<i class="fa fa-trash-o"></i>', ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'delete', $row->id, $request->params['pass'][0]], ['escape' => false, 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $row->id)]
        );

        $action['View'] = $helper->Html->link(
                '<i class="fa fa-arrows-alt"></i>', ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'view', $row->id, $request->params['pass'][0]], ['escape' => false, 'class' => 'btn btn-info btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'View')]
        );
        return $action;
    }

    public function formMain(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];
        $request = Router::getRequest();
        
        if (!empty($event->result)) {
            $blocks = $event->result;
        }
        if ($request->action == 'editLanguage') {
            $setting = new Setting();
            $fileds = json_decode($setting->getOption('Translation.Categories'),true);
            if(!empty($fileds)){
                if(!in_array('slug', $fileds)){
                    unset($blocks['default']['slug']);   
                }
                if(!in_array('name', $fileds)){
                    unset($blocks['default']['name']);
                }
                if(!in_array('description', $fileds)){
                    unset($blocks['default']['description']);
                }    
            }
        }
        // Add Extra Fields
        $metas = (new Metas())->parseform();
        foreach($metas as $k=>$meta){
            if(isset($viewVars['category']->{$k})){
                $metas[$k]['value'] = $viewVars['category']->{$k};
            }
        }

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
                case 'model':
                    $extraFields = (new System())->modelsExtraFields();
                    $fields[$key]['value'] = $helper->view($field['label'], $extraFields[$views->model]);
                    break;
                case 'status':
                    $fields[$key]['value'] = $helper->view($field['label'], ($views->status == 1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'));
                    break;
                case 'options':
                    if (!empty($views->options)) {
                        $options = json_decode($views->options, true);
                        if (count($options) > 0) {
                            $options = Hash::combine($options, '{n}.key', ['%s = %s', '{n}.key', '{n}.value']);
                            $fields[$key]['value'] = $helper->view($field['label'], implode('<br />', $options));
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
