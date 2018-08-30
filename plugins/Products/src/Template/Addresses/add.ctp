<?php

use Settings\Utility\Setting;
use Cake\Core\Configure;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Add Address'));
$this->Html->addCrumb(__d('ittvn', 'Addresses'), ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Add Address'), $this->request->here);
echo $this->Html->script('address');
?>
<div class="row">
    <div id="page-header" class="col-md-24">
        <h1 id="page-title"><?= __d('ittvn', 'Add Address'); ?></h1> 
    </div>
    <div id="col-main" class="col-md-24 register-page clearfix">
        <div class="row checkout-form">
            <?= $this->cell('Products.Customers::menu'); ?>
            <div class="col-xs-24 col-md-17 pull-right">
                <div class="row box_title">
                    <div class="col-md-24">
                        <h6 class="sb-title"><?= __d('ittvn', 'Add Address'); ?></h6>
                    </div>
                </div> 
                <div class="row box_content_main">
                    <div class="col-md-24">
                        <div class="row">
                            <div class="col-md-20">
                                <?= $this->Flash->render() ?>
                                <?php
                                echo $this->Form->create($address, ['class' => 'form-horizontal']);
                                echo $this->Form->input('name', [
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Name'), 'class' => 'col-sm-8'],
                                    'templates' => [
                                        'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);
                                echo $this->Form->input('company', [
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Company'), 'class' => 'col-sm-8'],
                                    'templates' => [
                                        'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);
                                echo $this->Form->input('phone', [
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Phone'), 'class' => 'col-sm-8'],
                                    'templates' => [
                                        'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('country_id', [
                                    'type' => 'hidden',
                                    'class' => 'form-control',
                                    'value' => $setting->getThemeOption('country')
                                ]);

                                echo $this->Form->input('province_id', [
                                    'type' => 'select',
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Province'), 'class' => 'col-sm-8'],
                                    'choose'=>1,
                                    'options' => [],
                                    'templates' => [
                                        'select' => '<div class="col-sm-16"><select name="{{name}}"{{attrs}}>{{content}}</select></div>'
                                    ]
                                ]);

                                echo $this->Form->input('city_id', [
                                    'type' => 'select',
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'CIty'), 'class' => 'col-sm-8'],
                                    'choose'=>1,
                                    'options' => [],
                                    'templates' => [
                                        'select' => '<div class="col-sm-16"><select name="{{name}}"{{attrs}}>{{content}}</select></div>'
                                    ]
                                ]);

                                echo $this->Form->input('ward_id', [
                                    'type' => 'select',
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Ward'), 'class' => 'col-sm-8'],
                                    'choose'=>1,
                                    'options' => [],
                                    'templates' => [
                                        'select' => '<div class="col-sm-16"><select name="{{name}}"{{attrs}}>{{content}}</select></div>'
                                    ]
                                ]);

                                echo $this->Form->input('address', [
                                    'class' => 'form-control',
                                    'label' => ['text' => __d('ittvn', 'Address'), 'class' => 'col-sm-8'],
                                    'templates' => [
                                        'input' => '<div class="col-sm-16"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('default', [
                                    'type' => 'checkbox',
                                    'label' => ['text' => __d('ittvn', 'Default'), 'class' => 'col-md-offset-8 label_checkbox'],
                                    'templates' => [
                                        'nestingLabel' => '<label{{attrs}}>{{input}} {{text}}</label>',
                                    ]
                                ]);
                                ?>
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