<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $userMeta->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $userMeta->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List User Metas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="userMetas form large-9 medium-8 columns content">
    <?= $this->Form->create($userMeta) ?>
    <fieldset>
        <legend><?= __('Edit User Meta') ?></legend>
        <?php
            echo $this->Form->input('key');
            echo $this->Form->input('value');
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
