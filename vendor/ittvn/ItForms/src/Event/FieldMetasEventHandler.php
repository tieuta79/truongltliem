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

class FieldMetasEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Tables.FieldMetas.header' => 'header',
            'Admin.Tables.FieldMetas.rowAction' => 'rowAction'
        ];
    }

    public function header(Event $event) {
        $headers = $event->subject()['header'];
        $request = Router::getRequest();

        $forms = TableRegistry::get('ItForms.Forms')->find()->find('network')->select(['id'])->where(['slug' => $request->params['pass'][0]])->first();
        $fields = TableRegistry::get('ItForms.Fields')->find('list')->find('network')->where(['form_id' => $forms->id, 'delete' => 0]);
        $he['id'] = ['label' => 'Id', 'sort' => 1, 'filter' => 'text'];
        if ($fields->count() > 0) {
            foreach ($fields as $k => $field) {
                $fieldVariable = Inflector::variable($field);
                $he[$fieldVariable] = ['label' => $field, 'sort' => 1, 'filter' => 'text',];
            }

            return $he;
        } else {
            return $headers;
        }
    }

    function rowAction(Event $event) {
        $action = $event->subject()['action'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        $action['Edit'] = '';
        $action['View'] = '';
        $action['Delete'] = $helper->Form->postLink(
                '<i class="fa fa-trash-o"></i>', ['plugin' => 'ItForms', 'controller' => 'FieldMetas', 'action' => 'delete', $row->id, $request->params['pass'][0]], ['escape' => false, 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $row->id)]
        );
        return $action;
    }

}
