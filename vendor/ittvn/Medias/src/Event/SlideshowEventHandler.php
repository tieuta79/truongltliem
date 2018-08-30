<?php

namespace Medias\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\View\View;
use Settings\Utility\Setting;
use Cake\Core\Configure;

class SlideshowEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Forms.Slideshow.main' => 'formMain',
            'Admin.Forms.Slideshow.sidebar' => 'formSidebar',
            'Admin.Tables.Slideshow.row' => 'addRow',
            'Admin.Tables.Slideshow.rowAction' => 'rowAction'
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
                case 'type':
                    $result[$key] = Configure::read('Slideshow.Type.' . $row->type);
                    break;
            }
        }
        return $result;
    }

    public function formMain(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];
        $request = Router::getRequest();

        if (!empty($event->result)) {
            $blocks = $event->result;
        }

        $view = new View();
        $blocks['settings']['config'] = [
            'type' => 'html',
            'html' => $view->element('Medias.config_slideshow', ['slideshow' => $viewVars['slideshow']])
        ];
        return $blocks;
    }

    public function formSidebar(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];
        $request = Router::getRequest();

        if (!empty($event->result)) {
            $blocks = $event->result;
        }

        if (isset($blocks['layout'])) {
            foreach ($blocks['layout'] as $k => $layout) {
                if ($k != 'label' && isset($viewVars['slideshow']->config['layout'][$k])) {
                    $blocks['layout'][$k]['value'] = $viewVars['slideshow']->config['layout'][$k];
                }
            }
        }

        return $blocks;
    }

    function rowAction(Event $event) {
        $action = $event->subject()['action'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        if ($row->type == 3) {
            $action['Slides'] = $helper->Html->link(
                    '<i class="fa fa-slideshare"></i>', ['plugin' => 'Medias', 'controller' => 'Slideshow', 'action' => 'slides', $row->id], ['escape' => false, 'class' => 'btn btn-warning btn-xs', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Add slide')]
            );
        }
        unset($action['View']);
        return $action;
    }

}
