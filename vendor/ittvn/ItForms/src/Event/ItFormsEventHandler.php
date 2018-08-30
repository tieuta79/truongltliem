<?php

namespace ItForms\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Ittvn\Utility\System;
use Settings\Utility\Setting;
use Metas\Utility\Metas;
use Cake\Utility\Text;

class ItFormsEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Menus.beforeRender' => ['callable' => 'beforeRenderMenus', 'priority' => 100],
            'Admin.Tables.Fields.rowAction' => 'rowAction'
        ];
    }

    public function rowAction(Event $event) {
        $action = $event->subject()['action'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        $action['Edit'] = $helper->Html->link(
                '<i class="fa fa-pencil-square-o"></i>', ['plugin' => 'ItForms', 'controller' => 'Fields', 'action' => 'edit', $row->id, $request->params['pass'][0]], ['escape' => false, 'class' => 'btn btn-success btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit')]
        );

        $action['Delete'] = $helper->Form->postLink(
                '<i class="fa fa-trash-o"></i>', ['plugin' => 'ItForms', 'controller' => 'Fields', 'action' => 'delete', $row->id, $request->params['pass'][0]], ['escape' => false, 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $row->id)]
        );

        $action['View'] = $helper->Html->link(
                '<i class="fa fa-arrows-alt"></i>', ['plugin' => 'ItForms', 'controller' => 'Fields', 'action' => 'view', 'slug' => $row->slug, 'type' => $request->params['pass'][0], 'prefix' => false], ['escape' => false, 'class' => 'btn btn-info btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'View'), 'target' => '_blank']
        );
        return $action;
    }

    public function beforeRenderMenus(Event $event) {
        $menus = $event->subject()['menus'];
        $options = $event->subject()['options'];

        if (!empty($event->result) && isset($event->result['menus'])) {
            $menus = $event->result['menus'];
        }

        if (!empty($event->result) && isset($event->result['options'])) {
            $options = $event->result['options'];
        }

        $forms = TableRegistry::get('ItForms.Forms')->find()->where(['menu' => 1]);
        if ($forms->count() > 0) {
            $priority = 15;
            foreach ($forms as $form) {
                //$form_singularize = Inflector::singularize($form->name);
                $menus[$form->slug] = [
                    'icon' => 'fa fa-certificate',
                    'title' => $form->name,
                    'url' => '#',
                    'child' => [
                        'AddField' . $form->slug => [
                            'icon' => 'fa fa-circle-o',
                            'title' => 'Add Fields',
                            'url' => [
                                'plugin' => 'ItForms',
                                'controller' => 'Fields',
                                'action' => 'addField',
                                'prefix' => 'admin',
                                $form->slug
                            ]
                        ],
                        'ListFields' . $form->slug => [
                            'icon' => 'fa fa-circle-o',
                            'title' => 'List Fields',
                            'url' => [
                                'plugin' => 'ItForms',
                                'controller' => 'Fields',
                                'action' => 'indexFields',
                                'prefix' => 'admin',
                                $form->slug
                            ]
                        ],
                        'ManagerDataForm' . $form->slug => [
                            'icon' => 'fa fa-circle-o',
                            'title' => 'Manager Data Form',
                            'url' => [
                                'plugin' => 'ItForms',
                                'controller' => 'FieldMetas',
                                'action' => 'index',
                                'prefix' => 'admin',
                                $form->slug
                            ]
                        ]
                    ],
                    'priority' => $priority
                ];

                $priority++;
            }
        }

        return ['menus' => $menus];
    }

}
