<?php
use Cake\Utility\Inflector;

$assocTable = $this->request->params['pass'][0];
$assocId = $this->request->params['pass'][1];
$assocSingularTable = Inflector::singularize($assocTable);
$assocPluralTable = Inflector::pluralize($assocTable);
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $message->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $message->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Messages'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="messages form large-9 medium-8 columns content">
    <?= $this->Form->create($message) ?>
    <fieldset>
        <legend><?= __('Edit Relation Message') ?></legend>
        <?php
        echo $this->Form->input('users.message_id', ['type' => 'hidden','value'=>$assocId]);
            echo $this->Form->input('first_name');
            echo $this->Form->input('middle_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('email');
            echo $this->Form->input('avatar');
            echo $this->Form->input('sex');
            echo $this->Form->input('birthday', ['empty' => true]);
            echo $this->Form->input('phone');
            echo $this->Form->input('public_key');
            echo $this->Form->input('private_key');
            echo $this->Form->input('active_code');
            echo $this->Form->input('role_id');
            echo $this->Form->input('status');
            echo $this->Form->input('delete');
            echo $this->Form->input('users._ids', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
