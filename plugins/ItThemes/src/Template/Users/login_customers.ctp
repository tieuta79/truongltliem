<?php

use Settings\Utility\Setting;
use Cake\Core\Plugin;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Login'));
$this->Html->addCrumb(__d('ittvn', 'Login'), $this->request->here);
$this->assign('full-width', true);
$this->Form->templates(include Plugin::path('ItThemes') . DS . 'config' . DS . 'form-templates.php');
?>

<div class="container">
    <h3 class="text-xs-center text-md-center">
        Thông tin đăng nhập <br />
        <i class="fa fa-user-circle" aria-hidden="true"></i> 
    </h3>


    <div class="row pt-2">
        <div class="col-md-8 offset-md-2 form">
            <div class="form-login">
                <?php
                if ($this->request->isAjax) {
                    echo $this->Form->create('Users', ['data-validate' => 'ajax', 'callback' => 'itform.login']);
                } else {
                    echo $this->Form->create('Users');
                }
                ?>
                <div class="col-md-12">
                    <?= $this->Flash->render('auth'); ?>
                    <?= $this->Flash->render() ?>
                </div>
                <div id="login-form">
                    <?php
                    echo $this->Form->input('email', [
                        'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Email')],
                        'placeholder' => __d('ittvn', 'Email'),
                        'data-validate' => json_encode([
                                ['empty' => __d('ittvn', 'Email is not empty.')],
                                ['email' => __d('ittvn', 'Email is not correct.')]
                        ]),
                        'class' => 'form-control',
                        'templates' => [
                            'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                        ]
                    ]);

                    echo $this->Form->input('password', [
                        'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Password')],
                        'placeholder' => __d('ittvn', 'Password'),
                        'data-validate' => json_encode([
                                ['empty' => __d('ittvn', 'Password is not empty.')]
                        ]),
                        'class' => 'form-control',
                        'templates' => [
                            'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                        ]
                    ]);
                    ?>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <?= $this->Form->button(__d('ittvn', 'Login'), ['type' => 'submit', 'class' => 'btn btn-info pull-right btn-submit']); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-12 col-md-6 text-xs-center text-md-left">
                            <?= $this->Html->link('<i class="fa fa-hand-o-right" aria-hidden="true"></i> ' . __d('ittvn', 'Forgot your password?'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'forgot', 'role' => $setting->getOption('Users.role_default_register')], ['escape' => false, 'data-target' => '#itmodal_ajax', 'data-modal' => true,]); ?>
                        </div>
                        <div class="col-xs-12 col-md-6 text-xs-center text-md-right">
                            <?= $this->Html->link('<i class="fa fa-hand-o-right" aria-hidden="true"></i> ' . __d('ittvn', 'Register'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'register', 'role' => $setting->getOption('Users.role_default_register')], ['escape' => false, 'data-target' => '#itmodal_ajax', 'data-modal' => true,]); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-12 col-md-6 text-xs-center text-md-left">
                            <?= $this->Html->link('<i class="fa fa-google" aria-hidden="true"></i> ' . __d('ittvn', 'Login with Google'), '#', ['escape' => false, 'class' => 'btn-login-google']); ?>
                        </div>
                        <div class="col-xs-12 col-md-6 text-xs-center text-md-right">
                            <?= $this->Html->link('<i class="fa fa-facebook" aria-hidden="true"></i> ' . __d('ittvn', 'Login with Facebook'), '#', ['escape' => false, 'class' => 'btn-login-facebook']); ?>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>