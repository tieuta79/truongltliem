<?php

namespace Users\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Metas\Utility\Metas;
use Cake\ORM\TableRegistry;

class UsersEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            //'Admin.Users.Tables.SelectBoxAction' => 'addFilterSelects',
            'Admin.Tables.Users.header' => 'header',
            'Admin.Tables.Users.filterHeader' => 'filterHeader',
            'Admin.Tables.Users.row' => 'addRow',
            'Admin.Forms.Users.main' => 'formMain',
            'Admin.Forms.Users.sidebar' => 'formSidebar',
            'Admin.Views.Users' => 'view',
            'Admin.Tables.Users.rowAction' => 'rowAction'
        ];
    }

    public function filterHeader(Event $event) {
        $filters = $event->subject()['filter'];
        $request = Router::getRequest();
        foreach ($filters as $key => $filter) {
            if ($key == 'role_id') {
                $roles = TableRegistry::get('Users.Roles')->find('list')->where(['delete <>' => 1]);
                $options = '';
                foreach ($roles as $kr => $vr) {
                    $options .= '<option value="' . $kr . '">' . $vr . '</option>';
                }
                $filters[$key] = [
                    '<label class="select"><select class="form-control" style="width: 100%;"><option value="">Filter ' . $key . '</option>' . $options . '</select><i></i></label>' => [
                        'class' => 'hasinput smart-form'
                    ]
                ];
            }
        }
        return $filters;
    }
    
    public function header(Event $event) {
        $headers = $event->subject()['header'];
        $request = Router::getRequest();
        $role = '';
        if ($request->params['prefix'] == 'admin') {
            if ($request->params['action'] == 'index' && isset($request->params['pass'][0])) {
                $role = $request->params['pass'][0];
            }
        }
        
        if(!empty($role)){
            unset($headers['role_id']);
        }
        return $headers;
    }    

    public function addFilterSelects(Event $event) {
        $filterSelects = $event->subject()['filterSelects'];
        if (!empty($event->result)) {
            $filterSelects = $event->result;
        }
        $filterSelects['Roles'] = [
            'label' => 'Roles',
            'name' => 'role_id',
            'fields' => ['id', 'name']
        ];
        return $filterSelects;
    }

    public function addRow(Event $event) {
        $request = Router::getRequest();
        $headers = $event->subject()['header'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];

        $result = $event->subject()['data'];
        if (!empty($event->result)) {
            $result = $event->result;
        }

        $role_slug = '';
        if (isset($request->params['pass'][0])) {
            $role_slug = $request->params['pass'][0];
        }

        foreach ($headers as $key => $field) {
            switch ($field) {
                case 'avatar':
                    if (!empty($row->avatar)) {
                        $result[$key] = $helper->Html->image($row->avatar, ['width' => 50, 'class' => 'img-circle img-thumbnail']);
                    } else {
                        $result[$key] = '';
                    }
                    break;
                case 'last_name':
                    $result[$key] = $helper->Html->link($row->full_name, ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'edit', $row->id, $role_slug], ['data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit') . ': ' . $row->full_name]);
                    break;
            }
        }
        return $result;
    }

    function rowAction(Event $event) {
        $action = $event->subject()['action'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        $role_slug = '';
        //pr($request->params); die();
        if (isset($request->params['pass'][0])) {
            $role_slug = $request->params['pass'][0];
        }
        $action['Role'] = $helper->Html->link(
                '<i class="fa fa-users"></i>', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'roles', $row->id, $role_slug], ['escape' => false, 'class' => 'btn btn-success btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Role')]
        );
        
        $action['Edit'] = $helper->Html->link(
                '<i class="fa fa-pencil-square-o"></i>', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'edit', $row->id, $role_slug], ['escape' => false, 'class' => 'btn btn-success btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit')]
        );

        $action['Delete'] = $helper->Form->postLink(
                '<i class="fa fa-trash-o"></i>', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'delete', $row->id, $role_slug], ['escape' => false, 'class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $row->id)]
        );

        $action['View'] = $helper->Html->link(
                '<i class="fa fa-arrows-alt"></i>', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'view', $row->id, $role_slug], ['escape' => false, 'class' => 'btn btn-info btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'View')]
        );
        return $action;
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

    public function formSidebar(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];
        $request = Router::getRequest();
        $role = '';
        if ($request->params['prefix'] == 'admin') {
            if ($request->params['action'] == 'add' && isset($request->params['pass'][0])) {
                $role = $request->params['pass'][0];
            } else if ($request->params['action'] == 'edit' && isset($request->params['pass'][1])) {
                $role = $request->params['pass'][1];
            }
        }

        if (!empty($event->result)) {
            $blocks = $event->result;
        }

        if (!empty($role)) {
            unset($blocks['role']);
            $role_id = TableRegistry::get('Users.Roles')->findBySlug($role)->select(['id'])->first();
            $blocks['action']['role_id'] = [
                'type' => 'hidden',
                'value' => $role_id->id
            ];
        }

        return $blocks;
    }

    public function view(Event $event) {
        $fields = $event->subject()['fields'];
        $views = $event->subject()['views'];
        $helper = $event->subject()['helper'];

        foreach ($fields as $key => $field) {
            switch ($key) {
                case 'role_id':
                    $fields[$key]['value'] = $helper->view($field['label'], $views->role->name);
                    break;
                case 'avatar':
                    if (!empty($views->avatar)) {
                        $fields[$key]['value'] = $helper->view($field['label'], $helper->Html->image($views->avatar, ['width' => 50]));
                    }
                    break;
                default:
                    break;
            }
        }
        return $fields;
    }

}
