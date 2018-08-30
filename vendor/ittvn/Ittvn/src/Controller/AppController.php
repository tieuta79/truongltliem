<?php

namespace Ittvn\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Acl\Controller\Component\AclComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Settings\Utility\Setting;
use Cake\Core\App;
use Ittvn\Utility\Network;
use Ittvn\Utility\User;

//use Cake\Auth\DefaultPasswordHasher;

class AppController extends Controller {

    public $paginate = [
        'limit' => 10,
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Cookie');
        $this->loadComponent('Auth');
        $this->loadComponent('Acl.Acl');
        $this->loadComponent('Ittvn.Ittvn');
        $this->loadComponent('Ittvn.DataTable');
        $this->loadComponent('Users.Log');

        //$this->Cookie->config('path', '/');
        $this->Cookie->config([
            //'path' => '/',
            'expires' => '+10 days',
            'httpOnly' => true,
            'key' => 'ce1447b92033af63cb807ae0ada08ittvn2c76e60eeedd6d45a243e98224bd0e204fb'
        ]);

        $this->Auth->storage()->config('key', 'Auth.' . User::getSessionKey());
    }

    public function beforeFilter(Event $event) {
        //pr((new DefaultPasswordHasher)->hash($this->request->data['password']));die();
        $this->setAuth();
        $this->setParams();
    }

    public function setAuth() {
        $setting = new Setting();
        $rolesAdminLogin = User::getRoleAdminLogin();

        if ($this->request->prefix == 'admin') {
            if (Network::checkScopeByUrl($this->request->here()) == false) {
                //Login by sub domain or domain
                $this->Auth->config('loginAction', '/admin/login');
                if ($this->request->host() != Configure::read('Network.mainDomain')) {
                    //Login by sub domain or new domain
                    $this->Auth->config('authenticate', [
                        'Form' => [
                            'fields' => ['username' => 'username', 'password' => 'password'],
                            'scope' => ['Users.delete' => 0, 'Users.status' => 1],
                            'contain' => ['Roles'],
                            'userModel' => 'Users.Users',
                            'finder' => 'authDomain',
                        ]
                    ]);
                } else {
                    //Login by main domain
                    $this->Auth->config('authenticate', [
                        'Form' => [
                            'fields' => ['username' => 'username', 'password' => 'password'],
                            'scope' => ['Users.delete' => 0, 'Users.status' => 1, 'Roles.slug IN' => $rolesAdminLogin],
                            'contain' => ['Roles'],
                            'userModel' => 'Users.Users',
                        ]
                    ]);
                }
            } else {
                //Login by sub folder
                $this->Auth->config('loginAction', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login', 'prefix' => 'admin']);
                $this->Auth->config('loginRedirect', ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'dashboard', 'prefix' => 'admin']);
                $this->Auth->config('logoutRedirect', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login', 'prefix' => 'admin']);

                // Pass settings in using 'all'			
                $this->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'username', 'password' => 'password'],
                        'scope' => ['Users.delete' => 0, 'Users.status' => 1, 'Roles.slug IN' => $rolesAdminLogin],
                        'contain' => ['Roles'],
                        'userModel' => 'Users.Users',
                    //'finder' => 'authFolder',
                    ]
                ]);
            }
        } else {
            $this->Auth->config('loginAction', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login', 'role' => 'customers', 'prefix' => false]);
            $this->Auth->config('loginRedirect', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'view', 'role' => 'customers', 'prefix' => false]);
            $this->Auth->config('logoutRedirect', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login', 'role' => 'customers', 'prefix' => false]);

            if (Network::checkScopeByUrl($this->request->here()) == false) {
                $this->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'email', 'password' => 'password'],
                        'scope' => ['Users.delete' => 0, 'Users.status' => 1, 'Roles.slug NOT IN' => $rolesAdminLogin],
                        'contain' => ['Roles'],
                        'userModel' => 'Users.Users'
                    ]
                ]);
            } else {
                $this->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'email', 'password' => 'password'],
                        'scope' => ['Users.delete' => 0, 'Users.status' => 1, 'Roles.slug NOT IN' => $rolesAdminLogin],
                        'contain' => ['Roles'],
                        'userModel' => 'Users.Users'
                    ]
                ]);
            }
        }

        //pr($this->request->session()->read());die();
        // Pass settings in using 'all'
        $this->Auth->config('authorize', [
            \Cake\Controller\Component\AuthComponent::ALL => ['actionPath' => 'controllers/'],
            'Acl.Actions' => ['actionPath' => 'controllers/'],
            'Controller'
        ]);
        Configure::write('sessionKey', $this->Auth->storage()->getConfig('key'));
    }

    public function setParams() {
        if ($this->request->prefix == 'admin' && $this->request->action == 'index' && !isset($this->request->query['trash'])) {
            $this->request->query['trash'] = 0;
        }
    }

    public function renderViews($views, $plugin = null) {
        if (empty($plugin)) {
            if (!empty($this->request->plugin)) {
                $plugin = $this->request->plugin;
            }
        }

        $setting = new Setting();
        $template_site = $setting->getOption('Themes.site');

        $paths = [
            App::path('Template', $template_site)[0],
            App::path('Template')[0],
            App::path('Template', $plugin)[0]
        ];

        $controllerPath = $this->request->controller . DS;

        $views = (array) $views;
        foreach ($views as $view) {
            foreach ($paths as $path) {
                if (file_exists($path . $controllerPath . str_replace('-', '_', $view) . '.ctp')) {
                    return $this->render($view);
                    break;
                }
            }
        }
    }

    public function renderEmailViews($views, $type = 'html', $plugin = null) {
        if (empty($plugin)) {
            if (!empty($this->request->plugin)) {
                $plugin = $this->request->plugin;
            }
        }

        $setting = new Setting();
        $template_site = $setting->getOption('Themes.site');

        $paths = [
            App::path('Template/Email/' . $type, $template_site)[0],
            App::path('Template/Email/' . $type)[0],
            App::path('Template/Email/' . $type, $plugin)[0]
        ];

        $views = (array) $views;
        foreach ($views as $view) {
            foreach ($paths as $k => $path) {
                if (file_exists($path . str_replace('-', '_', $view) . '.ctp')) {
                    if ($k == 0) {
                        return $template_site . '.' . $view;
                    } else if ($k == 1) {
                        return $view;
                    } else if ($k == 2) {
                        return $plugin . '.' . $view;
                    }
                    break;
                }
            }
        }
        return false;
    }

    public function isAuthorized($user) {
        $Collection = new ComponentRegistry($this);
        $acl = new AclComponent($Collection);
        $setting = new Setting();
        $user = User::get();

        if (!$user) {
            return false;
        }

        if ($this->request->prefix == 'admin') {
            if (!User::checkLoginMainDomain() || $user['role']['slug'] == $setting->getOption('Users.fullPermission')) {
                return true;
            }
        }

        $controller = $this->request->controller;
        $action = $this->request->action;
        $check = $acl->check($user['role']['slug'], "$controller/$action");
        return $check;
    }

}
