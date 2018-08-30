<?php

namespace Users\Controller\Admin;

use Users\Controller\AppController;
use Cake\Event\Event;
use Acl\AclExtras;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Ittvn\Utility\Network;
use Settings\Utility\Setting;
use Ittvn\Utility\User;
use Ittvn\Utility\System;

/**
 * Users Controller
 *
 * @property \Users\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login']);
    }

    /**
     * Login method
     *
     * @return void
     */
    public function login() {
        $this->viewBuilder()->layout('login');

        $urlRedirect = [];
        $scope = Network::checkScopeByUrl($this->request->here());

        if (!empty($this->request->params['?']['redirect'])) {
            $urlRedirect = $this->Auth->redirectUrl();
        } else {
            if ($scope == false) {
                $urlRedirect = '/admin';
            } else {
                $urlRedirect = $scope . '/admin';
            }
        }
        //print_r($this->request->is('post')); die('aaa');
        if (!User::checkLogin()) {
            if ($this->request->is('post')) {
                $this->eventManager()->dispatch(new Event('Controller.Admin.Users.beforeLogin', $this));
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);

                    $this->eventManager()->dispatch(new Event('Controller.Admin.Users.successLogin', $this));
                    if (empty($user['role']['url_after_login'])) {
                        $user['role']['url_after_login'] = $urlRedirect;
                    } else {
                        $user['role']['url_after_login'] = $this->stringToUrl($user['role']['url_after_login']);
                    }
                    return $this->redirect($user['role']['url_after_login']);
                }
                $this->eventManager()->dispatch(new Event('Controller.Admin.Users.failLogin', $this));
                $this->Flash->error(__d('ittvn', 'Invalid username or password, try again'));
            }
        } else {
            $this->redirect($urlRedirect);
        }
    }

    /**
     * logout method
     *
     * @return void
     */
    public function logout() {
        $this->eventManager()->dispatch(new Event('Controller.Admin.Users.logout', $this));
        $user = $this->Auth->identify();
        if (empty($user['role']['url_after_logout'])) {
            $user['role']['url_after_logout'] = $this->Auth->logout();
        } else {
            $user['role']['url_after_logout'] = $this->stringToUrl($user['role']['url_after_logout']);
        }
        return $this->redirect($user['role']['url_after_logout']);
    }

    public function stringToUrl($string) {
        if (is_array($string)) {
            return $string;
        }

        $url = [];
        if (!empty($string)) {
            $strings = explode('/', $string);
            if (count($strings) > 0) {
                foreach ($strings as $sts) {
                    if (strpos($sts, ':')) {
                        $u = explode(':', $sts);
                        $url[$u[0]] = trim($u[1]);
                    } else {
                        $url[] = trim($sts);
                    }
                }
            }
        }
        return $url;
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index($role = null) {
        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Users');
            if (count($tableParams['search']) > 0) {
                $query = $this->Users->find('search', $this->Users->filterParams($tableParams['search']));
            } else {
                $query = $this->Users->find();
            }

            $query->contain(['Roles', 'UserMetas']);
            if (!empty($role)) {
                $query->where(['Roles.slug' => $role]);
            }
            $query->find('network');
            $this->DataTable->table('Users', $query, $tableParams);
        }
        
        $this->set('role', $role);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->getNetwork($id, [
            'contain' => ['Roles', 'UserMetas']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($role = null) {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->saveNetwork($user)) {
                if (empty($role)) {
                    $this->Flash->success(sprintf(__d('ittvn', 'The %s has been saved.'), 'user'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->success(sprintf(__d('ittvn', 'The %s has been saved.'), $role));
                    return $this->redirect(['action' => 'index', $role]);
                }
            } else {
                if (empty($role)) {
                    $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be saved. Please, try again.'), 'user'));
                } else {
                    $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be saved. Please, try again.'), $role));
                }
            }
        }
        $roles = $this->Users->Roles->find('list')->find('network');
        $this->set(compact('user', 'roles', 'role'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $role = null) {
        $user = $this->Users->getNetwork($id, [
            'contain' => ['UserMetas']
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (empty($this->request->data['password'])) {
                unset($this->request->data['password']);
            }
            //$user = $this->Users->patchEntity($user, $this->request->data, ['associated' => ['Users.UserMetas']]);
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->saveNetwork($user)) {
                if (empty($role)) {
                    $this->Flash->success(sprintf(__d('ittvn', 'The %s has been saved.'), 'user'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->success(sprintf(__d('ittvn', 'The %s has been saved.'), $role));
                    return $this->redirect(['action' => 'index', $role]);
                }
            } else {
                if (empty($role)) {
                    $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be saved. Please, try again.'), 'user'));
                } else {
                    $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be saved. Please, try again.'), $role));
                }
            }
        }
        $roles = $this->Users->Roles->find('list')->find('network');
        $this->set(compact('user', 'roles', 'role'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Trash method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function trash($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->getNetwork($id);
        if ($this->Users->deleteNetwork($user)) {
            if (empty($role)) {
                $this->Flash->success(sprintf(__d('ittvn', 'The %s has been deleted.'), 'user'));
            } else {
                $this->Flash->success(sprintf(__d('ittvn', 'The %s has been deleted.'), $role));
            }
            return $this->redirect(['action' => 'index']);
        } else {
            if (empty($role)) {
                $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be deleted. Please, try again.'), 'user'));
            } else {
                $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be deleted. Please, try again.'), $role));
            }
            return $this->redirect(['action' => 'index', $role]);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $role = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->getNetwork($id);
        if ($this->Users->deleteNetwork($user)) {
            if (empty($role)) {
                $this->Flash->success(sprintf(__d('ittvn', 'The %s has been deleted.'), 'user'));
            } else {
                $this->Flash->success(sprintf(__d('ittvn', 'The %s has been deleted.'), $role));
            }
            return $this->redirect(['action' => 'index']);
        } else {
            if (empty($role)) {
                $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be deleted. Please, try again.'), 'user'));
            } else {
                $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be deleted. Please, try again.'), $role));
            }
            return $this->redirect(['action' => 'index', $role]);
        }
    }

    public function roles($id = null, $role = null) {
        $this->loadModel('Permissions');
        $this->loadModel('Settings.Settings');
        $settings = new Setting();
        $data = json_decode($settings->getOption('Users.permission'), true);
        $user = $this->Users->getNetwork($id);
        $role = $this->Users->find()
                        ->find('network')
                        ->contain(['Roles'])
                        ->select(['Roles.id', 'Roles.slug'])->where(['Users.id' => $id])->first();
        $role = $role->Roles->slug;
        $per_aro = $this->Acl->Aro->find()->where(['model' => 'Users', 'foreign_key' => $id])->find('network')->first();

        $select_per = [];
        $aro = [];
        if ($this->request->is('post')) {
            $value = json_decode($settings->getOption('Users.permission'), true);
            if (empty($value)) {
                $value = [];
            }
            $SelectedPermission = [];
            if (!empty($this->request->data['SelectedPermission'])) {
                $SelectedPermission = $this->request->data['SelectedPermission'];
            }
            $value['SelectedPermission']['Admin'][$role][$user->username] = $SelectedPermission;
            $this->Settings->updateAllNetwork([
                'value' => json_encode($value)
                    ], [
                'name' => 'Users.permission'
            ]);
            $data = $value;
            $allow = [];
            $tmp = [];
            $systems = new System();
            if (isset($this->request->data['SelectedPermission'])) {
                foreach ($this->request->data['SelectedPermission'] as $val) {
                    if (isset($data['Admin'][$val])) {
                        foreach ($data['Admin'][$val] as $k => $action) {
                            $this->Acl->allow($user->username, $action, '*');
                            $tmp[$k] = $action;
                            $results = $systems->acoscover($action, 4);
                            $action = $results['url'];
                            $node = $this->Acl->Aco->node($action)->toArray();
                            $allow = Hash::merge($allow, Hash::extract($node, '{n}.id'));
                        }
                    }
                }
            }
            //set deny permission            
            $denys = $this->Permissions->findByAroId($per_aro->id)->find('network')
                    ->where([
                'OR' => [
                    'Permissions._create <>' => -1,
                    'Permissions._read <>' => -1,
                    'Permissions._update <>' => -1,
                    'Permissions._delete <>' => -1
                ]
            ]);
            if (count($allow) > 0) {
                $denys->andWhere(['Permissions.aco_id NOT IN' => $allow]);
            }
            if ($denys->count() > 0) {
                foreach ($denys as $deny) {
                    $nodes = $this->Acl->Aco->find('path', ['for' => $deny->aco_id])->find('network')->toArray();
                    $node = Hash::extract($nodes, '{n}.alias');
                    $url_aco = '';
                    if (!empty($deny->params)) {
                        $url_aco = '/' . json_decode($deny->params)[0];
                    }
                    $this->Acl->deny($user->username, implode('/', $node) . $url_aco, '*');
                }
            }
            $this->Flash->success(__d('ittvn', 'Updated permission by role ' . $role . '.'));
        }
        //get permission from database
        if (isset($per_aro)) {
            $permissions = $this->Permissions->findByAroId($per_aro->id)->find('network')
                    ->where([
                        'OR' => [
                            '_create <>' => -1,
                            '_read <>' => -1,
                            '_update <>' => -1,
                            '_delete <>' => -1
                        ]
                    ])
                    ->toArray();
            $aco_ids = Hash::extract($permissions, '{n}.aco_id');
        }
        //End get permission from database
        $select_per = isset($data['SelectedPermission']['Admin'][$role][$user->username]) ? $data['SelectedPermission']['Admin'][$role][$user->username] : [];
        $this->set(compact('data', 'select_per', 'role'));
    }

    public function setpermission($user_slug = 'super-admin') {
        if (!User::checkLoginMainDomain() && $user_slug == 'super-admin') {
            $user_slug = 'admin';
        }
        $per_aro = $this->Acl->Aro->findByAlias($user_slug)->find('network')->first();
        $this->loadModel('Permissions');
        $this->loadModel('Settings.Settings');
        $this->loadModel('Metas.MetaTypes');
        $this->loadModel('ItForms.Forms');
        $settings = new Setting();
        $data = json_decode($settings->getOption('Users.permission'), true);
        if ($this->request->is('post')) {
            $value = json_decode($settings->getOption('Users.permission'), true);
            if (empty($value)) {
                $value = [];
            }
            if (!empty($this->request->data['sitenameAction']) || !empty($this->request->data['selectSite'])) {
                $value['Sites'][$this->request->data['sitenameAction']] = $this->request->data['selectSite'];
                $this->Settings->updateAllNetwork([
                    'value' => json_encode($value)
                        ], [
                    'name' => 'Users.permission'
                ]);
            }
            if (!empty($this->request->data['adminnameAction']) || !empty($this->request->data['selectAdmin'])) {
                $value['Admin'][$this->request->data['adminnameAction']] = $this->request->data['selectAdmin'];

                $this->Settings->updateAllNetwork([
                    'value' => json_encode($value)
                        ], [
                    'name' => 'Users.permission'
                ]);
            }
            $data = $value;
        }
        //get permission from database
        $permissions = $this->Permissions->findByAroId($per_aro->id)->find('network')
                ->where([
                    'OR' => [
                        '_create <>' => -1,
                        '_read <>' => -1,
                        '_update <>' => -1,
                        '_delete <>' => -1
                    ]
                ])
                ->toArray();
        $aco_ids = Hash::extract($permissions, '{n}.aco_id');
        //End get permission from database
        $acos = $this->Acl->Aco->find('threaded')->find('network')->toArray();
        $plugins = $this->listActions($acos[0]['children'], 0, $aco_ids, $user_slug);
        $roles = $this->Users->Roles->find('list', ['keyField' => 'slug', 'valueField' => 'name'])->find('network');
        $setpermission = $data;
        $meta_types = $this->MetaTypes->find('list', ['keyField' => 'id', 'valueField' => 'slug'])->find('network')->toArray();
        $forms = $this->Forms->find('list', ['keyField' => 'id', 'valueField' => 'slug'])->find('network')->toArray();
//        $plugins = $this->redata($plugins, $meta_types, $type = 'value');
//        $plugins = $this->redata($plugins, $forms, $type = 'key');
        
        $plugins = $this->redataold($plugins, $meta_types, $forms);
        $this->set(compact('roles', 'plugins', 'user_slug', 'setpermission', 'meta_types', 'forms'));
    }
//    public function testdata($plugins = null, $table = null) {
//        $arr = [];
//        foreach ($plugins as $key => $values) {
//            foreach ($values as $key1 => $value1) {
//                if ($key1 == 'Admin') {
//                    foreach ($value1 as $key2 => $value2) {
//                        $datac = [];
//                        if(!empty($table)){
//                            foreach ($table as $kt => $vt) {
//                                foreach ($value2['options'] as $kv2 => $v2) {
//                                    $datac[$kt][$key . '/' . $key1 . '/' . $key2 . '/' . $kv2 . '/' . $vt] = $v2 . '_' . $vt;
//                                }
//                                $arr[$key . '/' . $key1 . '/' . $key2 . '/' . $vt] = $datac[$kt];
//                            }
//                            return $arr;
//                        }
//                        
//                    }
//                }
//            }
//        }
//        
//    }
    
    public function redataold($plugins = null, $meta_types = null ,$forms = null){
        $arraySite = [];
        foreach ($plugins as $key => $values) {
            foreach ($values as $key1 => $value1) {
                if ($key1 == 'Admin') {
                    foreach ($value1 as $key2 => $value2) {
                        if ($key2 == 'Contents') {
                            $datac = [];
                            foreach ($meta_types as $kmt => $meta) {
                                foreach ($value2['options'] as $kv2 => $v2) {
                                    $datac[$kmt][$key . '/' . $key1 . '/' . $key2 . '/' . $kv2 . '/' . $meta] = $v2 . '_' . $meta;
                                    //unset($value2['options'][$kv2]);
                                }
                                $arraySite['PluginA'][$key . '/' . $key1 . '/' . $key2 . '/' . $meta] = $datac[$kmt];
                            }
                        } else if ($key2 == 'Fields' || $key2 == 'FieldMetas') {
                            if (count($forms) > 0) {
                                $datafo = [];
                                foreach ($forms as $keyform => $form) :
                                    foreach ($value2['options'] as $kv2 => $v2) {
                                    $datafo[$keyform][$key . '/' . $key1 . '/' . $key2 . '/' . $kv2 . '/' . $form] = $v2 . '_' . $form;                                                        
                                }
                                $arraySite['PluginA'][$key . '/' . $key1 . '/' . $key2 . '/' . $form] = $datafo[$keyform];
                                endforeach;
                            }
                        }
                        else {
                            foreach ($value2['options'] as $kv2 => $v2) {
                                $value2['options'][$key . '/' . $key1 . '/' . $key2 . '/' . $kv2] = $v2;
                                unset($value2['options'][$kv2]);
                            }
                            $arraySite['PluginA'][$key . '/' . $key1 . '/' . $key2] = $value2['options'];
                        }
                        //$arraySite['PluginA'][$key . '/' . $key1 . '/' . $key2] = $value2['options'];
                    }
                } else {
                    foreach ($value1['options'] as $kv1 => $v1) {
                        $value1['options'][$key . '/' . $key1 . '/' . $kv1] = $v1;
                        unset($value1['options'][$kv1]);
                    }
                    $arraySite['Plugin'][$key . '/' . $key1] = $value1['options'];
                }
            }
        }
        return $arraySite;
    }
    
    public function permission($user_slug = 'super-admin') {
        if (!User::checkLoginMainDomain() && $user_slug == 'super-admin') {
            $user_slug = 'admin';
        }
        $this->loadModel('Settings.Settings');
        $per_aro = $this->Acl->Aro->findByAlias($user_slug)->find('network')->first();
        $this->loadModel('Permissions');
        $settings = new Setting();
        if ($user_slug == $settings->getOption('Users.fullPermission')) {
            $this->set('fullpermission', true);
        }
        $userAcls = json_decode($settings->getOption('Users.permission'), true);
        if ($this->request->is('post')) {
            $role = $this->request->data['role'];
            if ($role != $settings->getOption('Users.fullPermission')) {
                $value = json_decode($settings->getOption('Users.permission'), true);
                if (empty($value)) {
                    $value = [];
                }

                $sellectedSite = [];
                if (!empty($this->request->data['SellectedSite'])) {
                    $sellectedSite = $this->request->data['SellectedSite'];
                }
                $value['Selected']['Sites'][$role] = $sellectedSite;

                $this->Settings->updateAllNetwork([
                    'value' => json_encode($value)
                        ], [
                    'name' => 'Users.permission'
                ]);

                $sellectedAdmin = [];
                if (!empty($this->request->data['SellectedAdmin'])) {
                    $sellectedAdmin = $this->request->data['SellectedAdmin'];
                }
                $value['Selected']['Admin'][$role] = $sellectedAdmin;
                $this->Settings->updateAllNetwork([
                    'value' => json_encode($value)
                        ], [
                    'name' => 'Users.permission'
                ]);

                $userAcls = $value;
            }
            $allow = [];
            $systems = new System();
            if (isset($this->request->data['SellectedSite'])) {
                foreach ($this->request->data['SellectedSite'] as $val) {
                    if (isset($userAcls['Sites'][$val])) {
                        foreach ($userAcls['Sites'][$val] as $action) {
                            $this->Acl->allow($role, $action, '*');
                            $node = $this->Acl->Aco->node($action)->toArray();
                            $allow = Hash::merge($allow, Hash::extract($node, '{n}.id'));
                        }
                    }
                }
            }
            if (isset($this->request->data['SellectedAdmin'])) {
                foreach ($this->request->data['SellectedAdmin'] as $val) {
                    if (isset($userAcls['Admin'][$val])) {
                        foreach ($userAcls['Admin'][$val] as $action) {
                            $this->Acl->allow($role, $action, '*');
                            $results = $systems->acoscover($action, 4);
                            $action = $results['url'];
                            $node = $this->Acl->Aco->node($action)->toArray();
                            $allow = Hash::merge($allow, Hash::extract($node, '{n}.id'));
                        }
                    }
                }
            }
            //Configure
            //set deny permission

            $denys = $this->Permissions->findByAroId($per_aro->id)->find('network')
                    ->where([
                'OR' => [
                    'Permissions._create <>' => -1,
                    'Permissions._read <>' => -1,
                    'Permissions._update <>' => -1,
                    'Permissions._delete <>' => -1
                ]
            ]);

            if (count($allow) > 0) {
                $denys->andWhere(['Permissions.aco_id NOT IN' => $allow]);
            }

            if ($denys->count() > 0) {
                foreach ($denys as $deny) {
                    $nodes = $this->Acl->Aco->find('path', ['for' => $deny->aco_id])->find('network')->toArray();
                    $node = Hash::extract($nodes, '{n}.alias');
                    $url_aco = '';
                    if (!empty($deny->params)) {
                        $url_aco = '/' . json_decode($deny->params)[0];
                    }
                    $this->Acl->deny($role, implode('/', $node) . $url_aco, '*');
                }
            }
            $this->Flash->success(__d('ittvn', 'Updated permission by role ' . $role . '.'));
        }
        //get permission from database
        $permissions = $this->Permissions->findByAroId($per_aro->id)->find('network')
                ->where([
                    'OR' => [
                        '_create <>' => -1,
                        '_read <>' => -1,
                        '_update <>' => -1,
                        '_delete <>' => -1
                    ]
                ])
                ->toArray();
        $aco_ids = Hash::extract($permissions, '{n}.aco_id');
        //End get permission from database
        $role = $this->Users->Roles->find()->select(['Roles.id', 'Roles.slug', 'Roles.name', 'Roles.admin_login'])->find('network');
        $roles = Hash::combine($role->toArray(), '{n}.slug', '{n}.name');
        $role_login = Hash::extract($role->toArray(), '{n}[slug=' . $user_slug . ']')[0]->admin_login;

        $settingPermission = $userAcls;
        $sellected = isset($settingPermission['Selected']) ? $settingPermission['Selected'] : [];
        $this->set(compact('roles', 'role_login', 'user_slug', 'settingPermission', 'sellected'));
    }

    public function redata($plugins = null, $meta_types = null, $type) {
        $arraySite = [];
        foreach ($plugins as $key => $values) {
            foreach ($values as $key1 => $value1) {
                if ($key1 == 'Admin') {
                    foreach ($value1 as $key2 => $value2) {
                        if (!empty($type)) {
                            $datac = [];
                            foreach ($meta_types as $kmt => $meta) {
                                foreach ($value2['options'] as $kv2 => $v2) {
                                    if ($type == 'value') {
                                        $datac[$kmt][$key . '/' . $key1 . '/' . $key2 . '/' . $kv2 . '/' . $meta] = $v2 . '_' . $meta;
                                    } else {
                                        $datac[$kmt][$key . '/' . $key1 . '/' . $key2 . '/' . $kv2 . '/' . $kmt] = $v2 . '_' . $meta;
                                    }
                                }
                                $arraySite['PluginA'][$key . '/' . $key1 . '/' . $key2 . '/' . $meta] = $datac[$kmt];
                            }
                        } else {
                            foreach ($value2['options'] as $kv2 => $v2) {
                                $value2['options'][$key . '/' . $key1 . '/' . $key2 . '/' . $kv2] = $v2;
                                unset($value2['options'][$kv2]);
                            }
                            $arraySite['PluginA'][$key . '/' . $key1 . '/' . $key2] = $value2['options'];
                        }
                    }
                } else {
                    if (isset($value1['options'])) {
                        foreach ($value1['options'] as $kv1 => $v1) {
                            $value1['options'][$key . '/' . $key1 . '/' . $kv1] = $v1;
                            unset($value1['options'][$kv1]);
                        }
                        $arraySite['Plugin'][$key . '/' . $key1] = $value1['options'];
                    }
                }
            }
        }
        return $arraySite;
    }

    public function deleteset() {        
        $this->loadModel('Settings.Settings');
        $settings = new Setting();
        $value = json_decode($settings->getOption('Users.permission'), true);
        $datas = explode(',', $this->request->params['pass'][0]);
        $success = false;
        if (count($datas) > 0) {
            foreach ($datas as $data) {
                if (array_search($data, array_keys($value['Admin']))) {
                    unset($value['Admin'][$data]);
                }
            }            
            $this->Settings->updateAllNetwork([
                'value' => json_encode($value)
                    ], [
                'name' => 'Users.permission'
            ]);
            $success = true;
        }
        $this->set(compact('success'));
        $this->set('_serialize', ['success']);
    }

    private function listActions($acos = [], $deep = 0, $selected = [], $role) {
        $skip_action = ['setAuth', 'setAdminLimitPaging', 'setParams', 'isAuthorized', 'renderViews', 'renderEmailViews', 'stringToUrl'];
        $skip_plugin = ['DebugKit', 'Acl', 'Ittvn', 'Migrations', 'Search', 'Templates'];
        $return = [];
        if (empty($acos))
            return [];
        
        foreach ($acos as $aco) {
            if ($aco->alias == 'Pages')
                continue;

            if (count($aco->children) > 0) {
                if (!in_array($aco->alias, $skip_plugin)) {
                    $child_deep = $deep + 1;
                    $return[$aco->alias] = $this->listActions($aco->children, $child_deep, $selected, $role);
                }
            } else {
                if ($deep != 0 && !in_array($aco->alias, $skip_action)) {
                    $return['options'][$aco->alias] = $aco->alias;
                    if (in_array($aco->id, $selected) || $role == Configure::read('Settings.Users.fullPermission')) {
                        $return['default'][] = $aco->alias;
                    }
                }
            }
        }
        
        return $return;
    }

    public function buildAcl($sync = 'sync') {
        User::buildPermission($sync);
        $this->redirect($this->request->referer());
    }

    private function defaultPermission() {
        $this->Acl->allow('admin', 'Users/index', ['create']);
    }

}