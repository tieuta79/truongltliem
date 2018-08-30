<?php

use Settings\Utility\Setting;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'My account'));
$this->Html->addCrumb(__d('ittvn', 'My account'), $this->request->here);
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
                    <strong><?= __d('ittvn', 'Cập nhật thông tin'); ?></strong>
                </h3>
            </div> 
            <div class="box-content">
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Thông tin cá nhân
                            </a>
                        </div>

                        <div id="collapseOne" class="collapse show in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true">
                            <?= $this->Form->create($user, ['url' => Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'updateInfo', 'role' => $this->request->role]), 'data-validate' => 'ajax', 'callback' => 'itform.update_info']); ?>
                            <div class="card-block form m-2">
                                <?php
                                echo $this->Form->input('message', [
                                    'type' => 'hidden',
                                    'value' => __d('ittvn', 'Cập nhật thông tin cá nhân.'),
                                    'templates' => [
                                        'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
                                    ]
                                ]);
                                echo $this->Form->input('first_name', [
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'First Name')],
                                    'placeholder' => __d('ittvn', 'First Name'),
                                    'data-validate' => json_encode([
                                            ['empty' => __d('ittvn', 'First Name is not empty.')]
                                    ]),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('middle_name', [
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Middle Name')],
                                    'placeholder' => __d('ittvn', 'Middle Name'),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('last_name', [
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Last Name')],
                                    'placeholder' => __d('ittvn', 'Last Name'),
                                    'data-validate' => json_encode([
                                            ['empty' => __d('ittvn', 'Last Name is not empty.')]
                                    ]),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('sex', [
                                    'type' => 'radio',
                                    'multiple' => true,
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Sex')],
                                    'class' => 'form-control',
                                    'options' => Configure::read('Users.sex'),
                                    'value' => 0,
                                    'templates' => [
                                        'inputContainer' => '<div class="form-group row form-inline {{type}}{{required}}">{{content}}</div>',
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('birthday', [
                                    'type' => 'text',
                                    'data-type' => 'date',
                                    'data-format' => str_replace(['d', 'm', 'Y'], ['dd', 'mm', 'yyyy'], $setting->getOption('Sites.format_date')),
                                    'readonly' => 'readonly',
                                    'value' => !empty($user->birthday) ? $user->birthday->format($setting->getOption('Sites.format_date')) : '',
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Birthday')],
                                    'data-validate' => json_encode([
                                            ['empty' => __d('ittvn', 'Birthday is not empty.')]
                                    ]),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><div class="input-group date"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span></div></div>',
                                    ]
                                ]);

                                echo $this->Form->input('phone', [
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Phone')],
                                    'placeholder' => __d('ittvn', 'Phone'),
                                    'data-validate' => json_encode([
                                            ['empty' => __d('ittvn', 'Phone is not empty.')],
                                            ['number' => __d('ittvn', 'Phone is number.')]
                                    ]),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
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
                    <div class="card">
                        <div class="card-header" role="tab" id="headingTwo">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Thông tin đơn vị
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <?= $this->Form->create($user, ['url' => Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'updateInfo', 'role' => $this->request->role]), 'data-validate' => 'ajax', 'callback' => 'itform.update_school']); ?>
                            <div class="card-block form m-2">
                                <?php
                                echo $this->Form->input('message', [
                                    'type' => 'hidden',
                                    'value' => __d('ittvn', 'Cập nhật thông tin đơn vị.'),
                                    'templates' => [
                                        'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
                                    ]
                                ]);
                                echo $this->Form->input('school_name_meta', [
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Name')],
                                    'placeholder' => __d('ittvn', 'Name'),
                                    'data-validate' => json_encode([
                                            ['empty' => __d('ittvn', 'School Name is not empty.')]
                                    ]),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('school_address_meta', [
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Address')],
                                    'placeholder' => __d('ittvn', 'Address'),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('school_phone_meta', [
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Phone')],
                                    'placeholder' => __d('ittvn', 'Phone'),
                                    'data-validate' => json_encode([
                                            ['empty' => __d('ittvn', 'School Phone is not empty.')]
                                    ]),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
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
                    <div class="card">
                        <div class="card-header" role="tab" id="headingThree">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Thay đổi mật khẩu
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                            <?= $this->Form->create($user, ['url' => Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'updateInfo', 'role' => $this->request->role]), 'data-validate' => 'ajax', 'callback' => 'itform.update_password']); ?>
                            <div class="card-block form m-2">
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
        </div>
    </div>
</div>