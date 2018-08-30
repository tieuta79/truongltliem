<?php

use Settings\Utility\Setting;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;
use Ittvn\Utility\Network;
use Cake\Utility\Hash;
use Cake\ORM\Table;
use Ittvn\Utility\User;

$setting = new Setting();

$this->assign('title', __d('ittvn', 'Settings website'));
$this->Html->addCrumb(__d('ittvn', 'Settings website'), $this->request->here);
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
                    <strong><?= __d('ittvn', 'Cài đặt website'); ?></strong>
                </h3>
            </div> 
            <div class="box-content">
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Thông tin website
                            </a>
                        </div>

                        <div id="collapseOne" class="collapse show in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true">
                            <?= $this->Form->create($site, ['url' => Router::url(['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'website', 'role' => $this->request->role]), 'data-validate' => 'ajax', 'callback' => 'itform.setting_website']); ?>
                            <div class="card-block form m-2">
                                <?php
                                echo $this->Form->input('title', [
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Title')],
                                    'placeholder' => __d('ittvn', 'Title'),
                                    'data-validate' => json_encode([
                                        ['empty' => __d('ittvn', 'Title is not empty.')]
                                    ]),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);

                                echo $this->Form->input('description', [
                                    'type' => 'textarea',
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Description')],
                                    'placeholder' => __d('ittvn', 'Description'),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'textarea' => '<div class="col-xs-10"><textarea name="{{name}}"{{attrs}}>{{value}}</textarea></div>',
                                    ]
                                ]);

                                echo $this->Form->input('status', [
                                    'type' => 'checkbox',
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Status')],
                                    'class' => 'custom-control-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="form-group row form-inline {{type}}{{required}}">{{content}}</div>',
                                        'checkbox' => '<div class="col-xs-10"><label class="custom-control custom-checkbox"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}><span class="custom-control-indicator"></span></label> </div>',
                                        'nestingLabel' => '<label{{attrs}} class="form-check form-check-inline">{{text}}</label> {{hidden}}{{input}}',
                                    ]
                                ]);
                                //check install db
                                if(!isset($check_hidden)){
                                    echo $this->Form->input('Database_demo', [
                                        'type' => 'checkbox',
                                        'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Install database demo')],
                                        'class' => 'custom-control-input',
                                        'templates' => [
                                            'inputContainer' => '<div class="form-group row form-inline {{type}}{{required}}">{{content}}</div>',
                                            'checkbox' => '<div class="col-xs-10"><label class="custom-control custom-checkbox"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}><span class="custom-control-indicator"></span></label> </div>',
                                            'nestingLabel' => '<label{{attrs}} class="form-check form-check-inline">{{text}}</label> {{hidden}}{{input}}',
                                        ]
                                    ]);
                                }
                                ?>

                                <div class="form-group row">
                                    <label class="col-xs-2 col-form-label">Giao diện hiện tại</label>
                                    <div class="col-xs-10">
                                        <?php if (!empty($info_theme)): ?>
                                            <?= $this->cell('ItThemes.Theme::setting_theme') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
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
                                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Thiết lập tên miền
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <?= $this->Form->create($domain, ['url' => Router::url(['plugin' => 'Sites', 'controller' => 'Domains', 'action' => 'add', 'role' => $this->request->role]), 'data-validate' => 'ajax']); ?>
                            <div class="card-block form m-2">
                                <div class="form-group row">
                                    <label class="col-xs-3 col-form-label">Website của bạn: </label>
                                    <div class="col-md-9">
                                        <?=
                                        $this->Html->link(
                                                $this->request->scheme() . '://' . $this->request->session()->read('Auth.User.username') . '.' . $this->request->host(), $this->request->scheme() . '://' . $this->request->session()->read('Auth.User.username') . '.' . $this->request->host(), ['target' => '_blank']
                                        );
                                        ?>
                                    </div>
                                </div>

                                <?php
                                echo $this->Form->input('name', [
                                    'label' => ['class' => 'col-xs-2 col-form-label', 'text' => __d('ittvn', 'Domain name')],
                                    'placeholder' => __d('ittvn', 'abc.com'),
                                    'data-validate' => json_encode([
                                        ['empty' => __d('ittvn', 'Domain name is not empty.')]
                                    ]),
                                    'class' => 'form-control',
                                    'templates' => [
                                        'input' => '<div class="col-xs-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                    ]
                                ]);
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Lưu ý:</h6>
                                        <ul>
                                            <li>Nếu sử dụng tên miên chính (domain name) thì nhập tên miên và trỏ tên miền về ip <?= $_SERVER['SERVER_ADDR']; ?></li>
                                            <li>Nếu sử dụng tên miền phụ (subdomain) thì CNAME tên miền phụ vơi domain <i>school.<?= $this->request->host(); ?></i></li>
                                        </ul>
                                    </div>
                                </div>
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