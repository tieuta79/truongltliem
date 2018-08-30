<?php

use Settings\Utility\Setting;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Update Password'));
$this->Html->addCrumb(__d('ittvn', 'Update Password'), $this->request->here);
$this->Form->templates(include Plugin::path('ItThemes') . DS . 'config' . DS . 'form-templates.php');
?>
<?php
$this->start('left');
echo $this->cell('ItThemes.Theme::menuCustomer');
$this->end();
?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-top">
                <h3>
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i> 
                    <strong><?= __d('ittvn', 'Thay đổi mật khẩu'); ?></strong>
                </h3>
            </div> 
            <div class="box-content">
                <?= $this->Form->create('User', ['url' => Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'updateInfo', 'role' => $this->request->role]), 'data-validate' => 'ajax', 'callback' => 'itform.update_password']); ?>
                <div class="form m-2">
                    <?php
                    echo $this->Form->input('message', [
                        'type' => 'hidden',
                        'value' => __d('ittvn', 'Đổi mật khẩu'),
                        'templates' => [
                            'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
                        ]
                    ]);
                    echo $this->Form->input('old_password', [
                        'type' => 'password',
                        'label' => ['class' => 'col-xs-3 col-form-label', 'text' => __d('ittvn', 'Old Password')],
                        'placeholder' => __d('ittvn', 'Old Password'),
                        'data-validate' => json_encode([
                                ['empty' => __d('ittvn', 'Old Password is not empty.')]
                        ]),
                        'class' => 'form-control',
                        'templates' => [
                            'input' => '<div class="col-xs-9"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                        ]
                    ]);
                    echo $this->Form->input('password', [
                        'label' => ['class' => 'col-xs-3 col-form-label', 'text' => __d('ittvn', 'New Password')],
                        'placeholder' => __d('ittvn', 'New Password'),
                        'value' => '',
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
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> ' . __d('ittvn', 'Save'), ['type' => 'submit', 'class' => 'btn btn-info pull-right btn-submit']); ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>