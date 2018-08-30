<?php

use Cake\Core\Configure;
use Settings\Utility\Setting;
use Cake\Core\Plugin;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Register'));
$this->Html->addCrumb(__d('ittvn', 'Register'), $this->request->here);
$this->assign('full-width', true);
$this->Form->templates(include Plugin::path('ItThemes') . DS . 'config' . DS . 'form-templates.php');
?>

<div class="container">
    <h3 class="text-xs-center text-md-center">
        <?= __d('ittvn', 'Register'); ?> <br />
        <i class="fa fa-key" aria-hidden="true"></i> 
    </h3>

    <div class="row pt-2">
        <div class="col-md-8 offset-md-2 form">
            <div class="form-login">
                <?php
                if ($this->request->isAjax) {
                    echo $this->Form->create($user, ['data-validate' => 'ajax', 'callback' => 'itform.register']);
                } else {
                    echo $this->Form->create($user);
                }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Flash->render('auth'); ?>
                        <?= $this->Flash->render() ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                        echo $this->Form->input('email', [
                            'label' => ['class' => 'col-xs-3 col-form-label', 'text' => __d('ittvn', 'Email')],
                            'placeholder' => __d('ittvn', 'Email'),
                            'data-validate' => json_encode([
                                    ['empty' => __d('ittvn', 'Email is not empty.')],
                                    ['email' => __d('ittvn', 'Email is not correct.')]
                            ]),
                            'class' => 'form-control',
                            'templates' => [
                                'input' => '<div class="col-xs-9"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                            ]
                        ]);
                        echo $this->Form->input('phone', [
                            'label' => ['class' => 'col-xs-3 col-form-label', 'text' => __d('ittvn', 'Phone')],
                            'placeholder' => __d('ittvn', 'Phone'),
                            'data-validate' => json_encode([
                                    ['empty' => __d('ittvn', 'Phone is not empty.')],
                                    ['number' => __d('ittvn', 'Phone is not number.')]
                            ]),
                            'class' => 'form-control',
                            'templates' => [
                                'input' => '<div class="col-xs-9"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                            ]
                        ]);

                        echo $this->Form->input('password', [
                            'label' => ['class' => 'col-xs-3 col-form-label', 'text' => __d('ittvn', 'Password')],
                            'placeholder' => __d('ittvn', 'Password'),
                            'data-validate' => json_encode([
                                    ['empty' => __d('ittvn', 'Password is not empty.')]
                            ]),
                            'class' => 'form-control',
                            'templates' => [
                                'input' => '<div class="col-xs-9"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                            ]
                        ]);

                        echo $this->Form->input('password_confirm', [
                            'type' => 'password',
                            'label' => ['class' => 'col-xs-3 col-form-label', 'text' => __d('ittvn', 'Confirm Password')],
                            'placeholder' => __d('ittvn', 'Confirm Password'),
                            'data-validate' => json_encode([
                                    ['empty' => __d('ittvn', 'Confirm Password is not empty.')]
                            ]),
                            'class' => 'form-control',
                            'templates' => [
                                'input' => '<div class="col-xs-9"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                            ]
                        ]);
                        ?>
                        <div class="form-group row">
                            <div class="col-xs-12 col-md-12">
                                <?= $this->Form->button(__d('ittvn', 'Register'), ['type' => 'submit', 'class' => 'btn btn-info pull-right btn-submit']); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 text-xs-center text-md-left">
                                <?= $this->Html->link('<i class="fa fa-hand-o-right" aria-hidden="true"></i> ' . __d('ittvn', 'If you already have an account'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login', 'role' => $setting->getOption('Users.role_default_register')], ['escape' => false, 'data-target' => '#itmodal_ajax', 'data-modal' => true,]); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-12 col-md-6 text-xs-center text-md-left">
                                <?= $this->Html->link('<i class="fa fa-google" aria-hidden="true"></i> ' . __d('ittvn', 'Register with Google'), '#', ['escape' => false, 'class' => 'btn-login-google']); ?>
                            </div>
                            <div class="col-xs-12 col-md-6 text-xs-center text-md-right">
                                <?= $this->Html->link('<i class="fa fa-facebook" aria-hidden="true"></i> ' . __d('ittvn', 'Register with Facebook'), '#', ['escape' => false, 'class' => 'btn-login-facebook']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>