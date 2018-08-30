<?php

namespace Users\Controller;

use Users\Controller\AppController;
use Cake\Event\Event;
use Ittvn\Utility\System;
use Settings\Utility\Setting;
use Cake\Utility\Text;
use Cake\Mailer\Email;
use Ittvn\Utility\Encryption;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \Users\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'register', 'verify', 'forgot', 'changepass']);
    }

    /**
     * Login method
     *
     * @return void
     */
    public function login() {
        $return = ['status' => false, 'data' => [], 'message' => ''];

        if ($this->request->is('post')) {
            $this->eventManager()->dispatch(new Event('Controller.User.Users.beforeLogin', $this));            
            $user = $this->Auth->identify();
            if ($user) {
                $system = new System();
                $this->Auth->setUser($user);
                $this->eventManager()->dispatch(new Event('Controller.User.Users.successLogin', $this));
                if (empty($user['role']['url_after_login'])) {
                    $user['role']['url_after_login'] = $this->Auth->redirectUrl();
                } else {
                    $user['role']['url_after_login'] = $system->stringToUrl($user['role']['url_after_login']);
                }
                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                    $return['status'] = true;
                    $return['data'] = $user;
                } else {
                    return $this->redirect($user['role']['url_after_login']);
                }
            } else {
                $this->eventManager()->dispatch(new Event('Controller.User.Users.failLogin', $this));

                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                    $return['message'] = __d('ittvn', 'Invalid username or password, try again');
                } else {
                    $this->Flash->error(__d('ittvn', 'Invalid username or password, try again'));
                }
            }
        }

        if ($this->request->is('post') && $this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
            $this->set(compact('return'));
            $this->set('_serialize', 'return');
        }

        $this->renderViews([
            'login-' . $this->request->role,
            'login',
        ]);
    }

    /**
     * logout method
     *
     * @return void
     */
    public function logout() {
        $this->eventManager()->dispatch(new Event('Controller.User.Users.logout', $this));
        $user = $this->Auth->user();
        $system = new System();
        if (empty($user['role']['url_after_logout'])) {
            $user['role']['url_after_logout'] = $this->Auth->logout();
        } else {
            $user['role']['url_after_logout'] = $system->stringToUrl($user['role']['url_after_logout']);
        }
        return $this->redirect($user['role']['url_after_logout']);
    }

    /**
     * Register method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function register() {
        $setting = new Setting();
        $system = new System();
        $this->loadModel('Users.Roles');
        $return = ['status' => false, 'data' => [], 'message' => ''];
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            if (!isset($this->request->role) || empty($this->request->role)) {
                $role_slug = $setting->getOption('Users.role_default_register');
            } else {
                $role_slug = $this->request->role;
            }

            $role = $this->Roles->find()->find('network')->where(['slug' => $role_slug]);
            if ($role->count() > 0) {
                $this->request->data['role_id'] = $role->first()->id;
            } else {
                $this->request->data['role_id'] = 0;
            }

            $this->request->data['username'] = $system->generateRandomString(8, 1);
            $this->request->data['active_code'] = Text::uuid();
            $this->request->data['status'] = 0;
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->saveNetwork($user)) {
                $this->request->data['full_name'] = $user->full_name;

                $email = new Email('default');
                $success = $email->to([$this->request->data['email'], $setting->getOption('Sites.admin_email')])
                        ->transport('gmail')
                        ->emailFormat('html')
                        ->viewVars(['user' => $this->request->data, 'role' => $this->request->role])
                        ->template($this->renderEmailViews('register'))
                        ->subject(sprintf(__d('ittvn', '%s %s registered successfull.'), __d('ittvn', $this->request->role), $this->request->data['email']))
                        ->send();

                $return['status'] = true;
                $return['data'] = $user;
                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                    $return['message'] = sprintf(__d('ittvn', '%s %s registered successfull. Please check email to active your account.'), __d('ittvn', $this->request->role), $this->request->data['email']);
                } else {
                    $this->Flash->success(sprintf(__d('ittvn', '%s %s registered successfull. Please check email to active your account.'), __d('ittvn', $this->request->role), $this->request->data['email']));
                }
            } else {
                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                    $return['message'] = __d('ittvn', 'The user could not be saved. Please, try again.');
                } else {
                    $this->Flash->error(__d('ittvn', 'The user could not be saved. Please, try again.'));
                }
            }
        }

        if ($this->request->is('post') && $this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
            $this->set(compact('return'));
            $this->set('_serialize', 'return');
        } else {
            $roles = $this->Roles->find('list', ['limit' => 200])->find('network');
            $this->set(compact('user', 'roles'));
            $this->set('_serialize', ['user']);

            $this->renderViews([
                'register-' . $this->request->role,
                'register',
            ]);
        }
    }

    public function forgot() {
        $return = ['status' => false, 'data' => [], 'message' => ''];
        $role = $this->request->role;
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->find()->find('network')
                    ->contain(['Roles' => function($q) use ($role) {
                            return $q->where(['slug' => $role]);
                        }])
                    ->where(['Users.email' => $this->request->data['email']]);
            if ($user->count() > 0) {
                $code = Encryption::encrypt($user->first()->id . '-' . strtotime('now'));
                $setting = new Setting();
                $email = new Email('default');
                $success = $email->to([$this->request->data['email'], $setting->getOption('Sites.admin_email')])
                        ->transport('gmail')
                        ->emailFormat('html')
                        ->viewVars(['user' => $user->first(), 'role' => $this->request->role, 'code' => $code])
                        ->template($this->renderEmailViews('forgot'))
                        ->subject(sprintf(__d('ittvn', '%s %s forgot password.'), __d('ittvn', $this->request->role), $this->request->data['email']))
                        ->send();

                $return['status'] = true;
                $return['data'] = $user;
                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                    $return['message'] = __d('ittvn', 'Please check email to change pasword.');
                } else {
                    $this->Flash->success(__d('ittvn', 'Please check email to change pasword.'));
                }
            } else {
                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                    $return['message'] = __d('ittvn', 'This email address does not exist.');
                } else {
                    $this->Flash->success(__d('ittvn', 'This email address does not exist.'));
                }
            }
        }

        if ($this->request->is('post') && $this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
            $this->set(compact('return'));
            $this->set('_serialize', 'return');
        }

        $this->renderViews([
            'forgot-' . $this->request->role,
            'forgot',
        ]);
    }

    public function changepass() {
        $return = ['status' => false, 'data' => [], 'message' => ''];
        if ($this->request->role && $this->request->code) {
            $role = $this->request->role;
            $code = Encryption::decrypt($this->request->code);
            if (!empty($code) && strpos($code, '-') == true) {
                $tmpcode = explode('-', $code);
                $time = new Time($tmpcode[1]);
                if ($time->isPast() <= 1) {
                    $user = $this->Users->find()->find('network')->where(['id' => $tmpcode[0]]);
                    if ($user->count() > 0) {
                        if ($this->request->is(['post', 'put'])) {
                            $user = $this->Users->patchEntity($user->first(), $this->request->data);
                            if ($this->Users->saveNetwork($user)) {

                                $email = new Email('default');
                                $success = $email->to([$user->email])
                                        ->transport('gmail')
                                        ->emailFormat('html')
                                        ->viewVars(['user' => $user, 'role' => $role])
                                        ->template($this->renderEmailViews('changepass'))
                                        ->subject(sprintf(__d('ittvn', '%s %s change password successfull.'), __d('ittvn', $this->request->role), $user->email))
                                        ->send();

                                $return['status'] = true;
                                $return['data'] = $user;
                                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                                    $return['message'] = __d('ittvn', 'Mật khẩu của bạn đã được thay đổi.');
                                } else {
                                    $this->Flash->success(__d('ittvn', 'Mật khẩu của bạn đã được thay đổi.'));
                                }
                            } else {
                                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                                    $return['message'] = __d('ittvn', 'Lấy lại mật khẩu đã bị lỗi.');
                                } else {
                                    $this->Flash->error(__d('ittvn', 'Lấy lại mật khẩu đã bị lỗi.'));
                                }
                            }
                        }
                    }
                } else {
                    if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                        $return['message'] = __d('ittvn', 'Mã lấy lại mật khẩu đã hết hạn.');
                    } else {
                        $this->Flash->error(__d('ittvn', 'Mã lấy lại mật khẩu đã hết hạn.'));
                    }
                }
            } else {
                if ($this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                    $return['message'] = __d('ittvn', 'Mã lấy lại mật khẩu bị lỗi hoặc không đúng. Xin vui lòng thử lại sau.');
                } else {
                    $this->Flash->error(__d('ittvn', 'Mã lấy lại mật khẩu bị lỗi hoặc không đúng. Xin vui lòng thử lại sau.'));
                }
            }
        }

        if ($this->request->is('post') && $this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
            $this->set(compact('return'));
            $this->set('_serialize', 'return');
        }

        $this->renderViews([
            'changepass-' . $this->request->role,
            'changepass',
        ]);
    }

    public function updateInfo() {
        $return = ['status' => false, 'data' => [], 'message' => ''];

        if ($this->request->is(['post', 'put']) && $this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
            if ($this->Auth->user('id')) {
                $user = $this->Users->find()->find('network')->where(['id' => $this->Auth->user('id')]);
                if ($user->count() > 0) {
                    $message = $this->request->data['message'];
                    unset($this->request->data['message']);
                    if (isset($this->request->data['old_password']) && !empty($this->request->data['old_password'])) {
                        if ((new DefaultPasswordHasher())->check($this->request->data['old_password'], $user->first()->password)) {
                            unset($this->request->data['old_password']);
                            $user = $this->Users->patchEntity($user->first(), $this->request->data);
                            if ($this->Users->saveNetwork($user)) {
                                $email = new Email('default');
                                $success = $email->to([$user->email])
                                        ->transport('gmail')
                                        ->emailFormat('html')
                                        ->viewVars(['user' => $user, 'role' => $this->request->role])
                                        ->template($this->renderEmailViews('updateinfo'))
                                        ->subject(sprintf(__d('ittvn', $message), __d('ittvn', $this->request->role), $user->email))
                                        ->send();

                                $userLogin = $this->Users->get($user->id, ['contain' => ['Roles']]);
                                $this->Auth->setUser($userLogin->toArray());
                                $this->Auth->identify();

                                $return['status'] = true;
                                $return['data'] = $user;
                                $return['message'] = sprintf(__d('ittvn', 'Thông tin %s đã được cập nhật.'), $user->email);
                            } else {
                                $return['message'] = __d('ittvn', 'Cập nhật thông tin đã bị lỗi.');
                            }
                        } else {
                            $return['message'] = __d('ittvn', 'Mật khẩu cũ không đúng.');
                        }
                    } else {
                        $user = $this->Users->patchEntity($user->first(), $this->request->data);
                        if ($this->Users->saveNetwork($user)) {
                            $email = new Email('default');
                            $success = $email->to([$user->email])
                                    ->transport('gmail')
                                    ->emailFormat('html')
                                    ->viewVars(['user' => $user, 'role' => $this->request->role])
                                    ->template($this->renderEmailViews('updateinfo'))
                                    ->subject(sprintf(__d('ittvn', $message), __d('ittvn', $this->request->role), $user->email))
                                    ->send();

                            $userLogin = $this->Users->get($user->id, ['contain' => ['Roles']]);
                            $this->Auth->setUser($userLogin->toArray());
                            $this->Auth->identify();

                            $return['status'] = true;
                            $return['data'] = $user;
                            $return['message'] = sprintf(__d('ittvn', 'Thông tin %s đã được cập nhật.'), $user->email);
                        } else {
                            $return['message'] = __d('ittvn', 'Cập nhật thông tin đã bị lỗi.');
                        }
                    }
                } else {
                    $return['data'] = 'redirect';
                }
            } else {
                $return['data'] = 'redirect';
            }
        }

        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }

    public function updatePassword() {

        $this->renderViews([
            'update-password-' . $this->request->role,
            'update-password',
        ]);
    }

    public function verify() {
        $role = $this->request->role;
        $user = $this->Users->find()->find('network')
                        ->contain([
                            'Roles' => function($q) use($role) {
                                return $q->where(['slug' => $role]);
                            }
                        ])->where(['Users.delete' => 0, 'Users.active_code' => $this->request->code]);

        if ($user->count() > 0) {
            $user = $user->first();
            $user->active_code = '';
            $user->status = 1;
            if ($this->Users->saveNetwork($user)) {
                $this->Flash->success(__d('ittvn', 'You verified account successfull.'));
            } else {
                $this->Flash->error(__d('ittvn', 'Error verify account successfull. Please, try again.'));
            }
        } else {
            $this->Flash->error(__d('ittvn', 'Error verify account successfull. Please, try again.'));
        }
        $this->redirect(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login', 'role' => $role]);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $this->set('users', $this->paginate($this->Users->find('network')));
        $this->set('_serialize', ['users']);

        $this->renderViews([
            'index-' . $this->request->role,
            'index',
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view() {
        $user = $this->Users->getNetwork($this->Auth->user('id'), [
            'contain' => ['Roles', 'UserMetas']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);

        $this->renderViews([
            'view-' . $this->request->role,
            'view',
        ]);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->saveNetwork($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Users.Roles');
        $roles = $this->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit() {
        $user = $this->Users->getNetwork($this->Auth->user('id'), [
            'contain' => ['Roles']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->params['pass'][0] = $this->Auth->user('id');
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->saveNetwork($user)) {
                $this->Auth->setUser($user->toArray());
                $this->Flash->success(sprintf(__d('ittvn', 'The %s has been saved.'), $this->request->role));
            } else {
                $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be saved. Please, try again.'), $this->request->role));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);

        $this->renderViews([
            'edit-' . $this->request->role,
            'edit',
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->getNetwork($id);
        if ($this->Users->deleteNetwork($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function uploadAvatarAjax() {
        $return = ['status' => false, 'data' => []];


        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }

}
