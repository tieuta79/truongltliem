<?php

use Cake\Core\Configure;
use Settings\Utility\Setting;
use Cake\Core\Plugin;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Thay đổi mật khẩu'));
$this->Html->addCrumb(__d('ittvn', 'Thay đổi mật khẩu'), $this->request->here);
$this->assign('full-width', true);
$this->Form->templates(include Plugin::path('ItThemes') . DS . 'config' . DS . 'form-templates.php');
?>

<div class="container">
    <h3 class="text-xs-center text-md-center">
        <?= __d('ittvn', 'Thay đổi mật khẩu'); ?> <br />
        <i class="fa fa-key" aria-hidden="true"></i> 
    </h3>

    <div class="row pt-2">
        <div class="col-md-8 offset-md-2 form">
            <div class="form-login">
                <?php
                if ($this->request->isAjax) {
                    echo $this->Form->create('user', ['data-validate' => 'ajax', 'callback' => 'itform.changepass']);
                } else {
                    echo $this->Form->create('user');
                }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Flash->render('auth'); ?>
                        <?= $this->Flash->render() ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                        echo $this->Form->input('password', [
                            'label' => ['class' => 'col-xs-3 col-form-label', 'text' => __d('ittvn', 'New Password')],
                            'placeholder' => __d('ittvn', 'New Password'),
                            'data-validate' => json_encode([
                                    ['empty' => __d('ittvn', 'New Password is not empty.')]
                            ]),
                            'class' => 'form-control',
                            'templates' => [
                                'input' => '<div class="col-xs-9"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                            ]
                        ]);

                        echo $this->Form->input('password_confirm', [
                            'type' => 'password',
                            'label' => ['class' => 'col-xs-3 col-form-label', 'text' => __d('ittvn', 'Confirm New Password')],
                            'placeholder' => __d('ittvn', 'Confirm Password'),
                            'data-validate' => json_encode([
                                    ['empty' => __d('ittvn', 'Confirm New Password is not empty.')]
                            ]),
                            'class' => 'form-control',
                            'templates' => [
                                'input' => '<div class="col-xs-9"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                            ]
                        ]);
                        ?>
                        <div class="form-group row">
                            <div class="col-xs-12 col-md-12">
                                <?= $this->Form->button(__d('ittvn', 'Chnage'), ['type' => 'submit', 'class' => 'btn btn-info pull-right btn-submit']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>