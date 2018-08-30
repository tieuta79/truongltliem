<?php

namespace ItThemes\Controller;

use ItThemes\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\View\View;
use Settings\Utility\Setting;

/**
 * Themes Controller
 *
 * @property \Themes\Model\Table\ThemesTable $Themes
 */
class ItThemesController extends AppController {

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['reloadElement']);
    }

    public function reloadElement() {
        $return = ['status' => false, 'data' => [], 'message' => ''];

        if ($this->request->is('post') && $this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {

            $filename = $this->request->data['element'];
            $system = new Setting();
            if (strpos('.', $filename) != true) {
                $filename = $system->getOption('Themes.site') . '.' . $filename;
            }

            $view = new View();
            $return['status'] = true;
            $return['data'] = $view->element($filename);
        } else {
            $element = '';
        }

        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }

}
