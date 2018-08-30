<% if($prefix=='Admin'){ %>
<?php $this->assign('title', __d('ittvn', 'Login')); ?>
<?= $this->Flash->render() ?>
<p class="login-box-msg">Sign in to start your session</p>
<?php echo $this->Form->create('Users'); ?>
    <div class="form-group has-feedback">
        <?= $this->Form->input('username',['label'=>false,'class'=>'form-control','placeholder'=>__d('ittvn','Username / Email'),'templates'=>['inputContainer'=>'{{content}}']]); ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <?= $this->Form->input('password',['label'=>false,'class'=>'form-control','placeholder'=>__d('ittvn','Password'),'templates'=>['inputContainer'=>'{{content}}']]); ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <?= $this->Form->input('remember',['type'=>'checkbox','label'=>__d('ittvn','Remember Me'),'templates'=>['inputContainer'=>'{{content}}','nestingLabel'=>'{{hidden}}<label{{attrs}}>{{input}} {{text}}</label>']]); ?>
            </div>
        </div>
        <div class="col-xs-4">
            <?php echo $this->Form->input(__d('ittvn','Sign In'),['type'=>'submit','class'=>'btn btn-primary btn-block btn-flat','templates'=>['submitContainer'=>'{{content}}']]); ?>
        </div><!-- /.col -->
    </div>
<?php echo $this->Form->end(); ?>
<% }else{ %>
<div class="users form">
<?= $this->Flash->render('auth') ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->input('username') ?>
        <?= $this->Form->input('password') ?>
    </fieldset>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
</div>
<% } %>