<?php

namespace Products\Controller\Admin;

use Extensions\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;

/**
 * Themes Controller
 *
 * @property \Themes\Model\Table\ThemesTable $Themes
 */
class ProductsController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function customers() {
        $this->loadModel('Users.Users');
        $query = $this->Users
                ->find('search', $this->Users->filterParams($this->request->query))
                ->contain(['Roles', 'UserMetas'])
                ->where(['Roles.slug'=>'customer']);
        $this->set('users', $this->paginate($query));
        $this->set('_serialize', ['users']);
    }

}
