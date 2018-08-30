<?php

namespace Metas\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Ittvn\Utility\System;
use Cake\Utility\Hash;

class MetaTypesEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.MetaTypes.Tables.SelectBoxAction' => 'addFilterSelects',
            'Admin.Tables.MetaTypes.row' => 'addRow',
            'Admin.Views.MetaTypes' => 'view',
            'Admin.Menus.beforeRender' => ['callable' => 'beforeRenderMenus', 'priority' => 1]
        ];
    }

    public function addFilterSelects(Event $event) {

        $filterSelects = $event->subject()['filterSelects'];
        if (!empty($event->result)) {
            $filterSelects = $event->result;
        }

        $contentTypes = (new System())->modelsContentTypes();

        $filterSelects['model'] = [
            'label' => 'Plugins',
            'name' => 'model',
            'options' => $contentTypes
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
                case 'icon':
                    $result[$key] = $helper->Html->tag('i', ' ' . $row->icon, ['class' => $row->icon]);
                    break;
                case 'model':
                    $result[$key] = $helper->Html->tag('span', $row->model, ['class' => 'badge badge-warning']);
                    break;
                case 'category':
                    $result[$key] = $row->category == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                    break;
                case 'multi_category':
                    $result[$key] = $row->multi_category == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                    break;
                case 'menu':
                    $result[$key] = $row->menu == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                    break;
            }
        }
        return $result;
    }

    public function form(Event $event) {
        
    }

    public function view(Event $event) {
        $fields = $event->subject()['fields'];
        $views = $event->subject()['views'];
        $helper = $event->subject()['helper'];

        foreach ($fields as $key => $field) {
            switch ($key) {
                case 'name':
                    $fields[$key]['value'] = $helper->view($field['label'], $helper->Html->tag('i', ' ' . $views->name, ['class' => $views->icon]));
                    break;
                case 'category':
                    $fields[$key]['value'] = $helper->view($field['label'], ($views->category == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'));
                    break;
                case 'multi_category':
                    $fields[$key]['value'] = $helper->view($field['label'], ($views->multi_category == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'));
                    break;
                case 'menu':
                    $fields[$key]['value'] = $helper->view($field['label'], ($views->menu == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'));
                    break;
                default:
                    break;
            }
        }
        return $fields;
    }

    public function beforeRenderMenus(Event $event) {
        $menus = $event->subject()['menus'];
        $options = $event->subject()['options'];

        $MetaCategories = TableRegistry::get('Metas.MetaCategories');

        $metaTypes = TableRegistry::get('Metas.MetaTypes')->find()
                ->find('network')
                ->where(['model' => 'Contents', 'menu' => 1])
                ->order('id', 'asc')
                ->formatResults(function($result) use($MetaCategories) {
                    return $result->map(function($row) use($MetaCategories) {
                                $mc = $MetaCategories->find()->find('network')->where(['meta_type_id' => $row->id]);
                                if ($mc->count() > 0) {
                                    $row['meta_categories'] = $mc->toArray();
                                } else {
                                    $row['meta_categories'] = [];
                                }
                                return $row;
                            });
                })
                ->toArray();
                
        $event = (new EventManager())->dispatch(new Event('Admin.Menus.PostType.beforeRender', ['metaTypes' => $metaTypes]));
        if (!empty($event->result)) {
            $metaTypes = $event->result;
        }

        if (count($metaTypes) > 0) {
            $priority = 5;
            foreach ($metaTypes as $metaType) {
                $metaType_singularize = Inflector::singularize($metaType->name);
                $menus[$metaType->name] = [
                    'icon' => $metaType->icon,
                    'title' => $metaType->name,
                    'url' => '#',
                    'child' => [
                        'All' . $metaType_singularize => [
                            'icon' => 'fa fa-circle-o',
                            'title' => 'All ' . $metaType_singularize,
                            'url' => [
                                'plugin' => 'Contents',
                                'controller' => 'Contents',
                                'action' => 'index',
                                'prefix' => 'admin',
                                $metaType->slug
                            ]
                        ],
                        'New' . $metaType_singularize => [
                            'icon' => 'fa fa-circle-o',
                            'title' => 'New ' . $metaType_singularize,
                            'url' => [
                                'plugin' => 'Contents',
                                'controller' => 'Contents',
                                'action' => 'add',
                                'prefix' => 'admin',
                                $metaType->slug
                            ]
                        ]
                    ],
                    'priority' => $priority
                ];

                if ($metaType->category == 1 && count($metaType->meta_categories) > 0) {
                    foreach ($metaType->meta_categories as $categories) {
                        $menus[$metaType->name]['child'][$categories->slug . $metaType_singularize] = [
                            'icon' => 'fa fa-circle-o',
                            'title' => $categories->name,
                            'url' => [
                                'plugin' => 'Contents',
                                'controller' => 'Categories',
                                'action' => 'index',
                                'prefix' => 'admin',
                                $categories->slug
                            ]
                        ];
                    }
                }

                $event = (new EventManager())->dispatch(new Event('Admin.Menus.PostType.afterRender', ['metaType' => $metaType, 'menus' => $menus]));
                if (!empty($event->result)) {
                    $menus = $event->result;                    
                }
                
                $priority++;
            }
        }

        return ['menus' => $menus];
    }

}
