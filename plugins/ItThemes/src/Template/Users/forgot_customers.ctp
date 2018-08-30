<?php

use Settings\Utility\Setting;
use Cake\Core\Plugin;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Forgot Password'));
$this->Html->addCrumb(__d('ittvn', 'Forgot Password'), $this->request->here);
$this->assign('full-width', true);
$this->Form->templates(include Plugin::path('ItThemes') . DS . 'config' . DS . 'form-templates.php');
?>

<div class="container">
    <h3 class="text-xs-center text-md-center">
        Lấy lại mật khẩu <br />
        <i class="fa fa-key" aria-hidden="true"></i> 
    </h3>


    <div class="row pt-2">
        <div class="col-md-8 offset-md-2 form">
            <div class="form-login">
                <?php
                if ($this->request->isAjax) {
                    echo $this->Form->create('Users', ['data-validate' => 'ajax']);
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
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->button(__d('ittvn', 'Send'), ['type' => 'submit', 'class' => 'btn btn-info pull-right btn-submit']); ?>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>