<?php

use Settings\Utility\Setting;
use Cake\Core\Configure;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Infomation'));
$this->Html->addCrumb(__d('ittvn', 'Infomation'), $this->request->here);
?>
<div class="row">
    <div id="page-header" class="col-md-24">
        <h1 id="page-title"><?= __d('ittvn', 'Infomation'); ?></h1> 
    </div>
    <div id="col-main" class="col-md-24 register-page clearfix">
        <div class="row checkout-form">
            <?= $this->cell('Products.Customers::menu'); ?>
            <div class="col-xs-24 col-md-17 pull-right">
                <div class="row box_title">
                    <div class="col-md-24">
                        <h6 class="sb-title">Infomation</h6>
                    </div>
                </div> 
                <div class="row box_content_main">
                    <div class="col-md-24">
                        <div class="row">
                            <div class="col-md-20">
                                <?= $this->Flash->render() ?>
                                <?php
                                echo $this->Form->create($user, ['class' => 'form-horizontal']);
                                echo $this->Form->input('id', ['type' => 'hidden', 'value' => $this->request->session()->read('Auth.User.id')]);
                                echo $this->Form->input('first_name', [
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'First Name'), 'class' => 'col-sm-8'],
                                    'templates' => [
                                        'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);
                                echo $this->Form->input('middle_name', [
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Middle Name'), 'class' => 'col-sm-8'],
                                    'templates' => [
                                        'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);
                                echo $this->Form->input('last_name', [
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Last Name'), 'class' => 'col-sm-8'],
                                    'templates' => [
                                        'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('sex', [
                                    'type' => 'select',
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Sex'), 'class' => 'col-sm-8'],
                                    'options' => Configure::read('Users.sex'),
                                    'templates' => [
                                        'select' => '<div class="col-sm-16"><select name="{{name}}"{{attrs}}>{{content}}</select></div>'
                                    ]
                                ]);

                                echo $this->Form->input('birthday', [
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Birthday'), 'class' => 'col-sm-8'],
                                    'minYear' => date('Y') - 50,
                                    'maxYear' => date('Y') - 10,
                                    'templates' => [
                                        'select' => '<div class="col-sm-4 input_date"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
                                        'dateWidget' => '{{day}} {{month}} {{year}} {{hour}} : {{minute}} : {{second}} {{meridian}}',
                                    ]
                                ]);

                                echo $this->Form->input('email', [
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Email'), 'class' => 'col-sm-8'],
                                    'readonly' => 'readonly',
                                    'templates' => [
                                        'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('changepass', [
                                    'type' => 'checkbox',
                                    'label' => ['text' => __d('ittvn', 'Change password'), 'class' => 'col-md-offset-8 label_checkbox'],
                                    'templates' => [
                                        //'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                        'nestingLabel' => '<label{{attrs}}>{{input}} {{text}}</label>',
                                    ]
                                ]);
                                ?>
                                <div class="box_change_pass">
                                    <?php
                                    echo $this->Form->input('password_old', [
                                        'type' => 'password',
                                        'class' => 'form-control',
                                        'label' => ['text' => __d('ittvn', 'Password old'), 'class' => 'col-sm-8'],
                                        'value' => '',
                                        'templates' => [
                                            'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                        ]
                                    ]);
                                    echo $this->Form->input('password', [
                                        'type' => 'password',
                                        'class' => 'form-control',
                                        'label' => ['text' => __d('ittvn', 'Password new'), 'class' => 'col-sm-8'],
                                        'value' => '',
                                        'required' => false,
                                        'templates' => [
                                            'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                        ]
                                    ]);
                                    echo $this->Form->input('password_confirm', [
                                        'type' => 'password',
                                        'class' => 'form-control',
                                        'label' => ['text' => __d('ittvn', 'Password confirm'), 'class' => 'col-sm-8'],
                                        'value' => '',
                                        'templates' => [
                                            'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                        ]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-16">
                                    <?= $this->Form->button(__d('ittvn', 'Update'), ['class' => 'btn btn-2']); ?>
                                </div>
                                <?php
                                echo $this->Form->end();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>   
</div>