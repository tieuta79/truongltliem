<?php $this->assign('title', __d('ittvn', 'Login')); ?>
<?php

use Cake\Core\Configure; ?>
<div class="row">
    <div class="col-md-offset-4 col-xs-12 col-sm-12 col-md-4">
        <?php echo $this->Flash->render('auth'); ?>
        <?= $this->Flash->render() ?>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-4 col-xs-12 col-sm-12 col-md-4">
        <div class="well no-padding">			
            <?= $this->Flash->render() ?>
            <?php echo $this->Form->create('Users', ['id' => 'login-form', 'class' => 'smart-form client-form']); ?>
            <header><?= __d('ittvn', 'Sign In'); ?></header>

            <fieldset>
                <section>
                    <?=
                    $this->Form->input('username', [
                        'placeholder' => __d('ittvn', 'Username / Email'),
                        'templates' => [
                            'inputContainer' => '<label class="input {{type}}{{required}}">{{content}}</label>',
                            'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/> <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b>',
                        ]
                    ]);
                    ?>
                </section>
                <section>
                    <?=
                    $this->Form->input('password', [
                        'placeholder' => __d('ittvn', 'Password'),
                        'templates' => [
                            'inputContainer' => '<label class="input {{type}}{{required}}">{{content}}</label>',
                            'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/> <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b>',
                        ]
                    ]);
                    ?>
                </section>
            </fieldset>
            <footer>
                <?php echo $this->Form->input(__d('ittvn', 'Sign In'), ['type' => 'submit', 'class' => 'btn btn-primary', 'templates' => ['submitContainer' => '{{content}}']]); ?>
            </footer>
            <?php echo $this->Form->end(); ?>

        </div>

        <h5 class="text-center"> - Or sign in using -</h5>

        <ul class="list-inline text-center">		
            <li>
                <a href="javascript:void(0);" class="btn btn-primary btn-circle"><i class="fa fa-facebook"></i></a>
            </li>
            <li>
                <a href="javascript:void(0);" class="btn btn-info btn-circle"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
                <a href="javascript:void(0);" class="btn btn-warning btn-circle"><i class="fa fa-linkedin"></i></a>
            </li>
        </ul>

    </div>
</div>