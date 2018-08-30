<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $usersLog->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $usersLog->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users Logs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Logs'), ['controller' => 'Logs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Log'), ['controller' => 'Logs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usersLogs form large-9 medium-8 columns content">
    <?= $this->Form->create($usersLog) ?>
    <fieldset>
        <legend><?= __('Edit Users Log') ?></legend>
        <?php
            echo $this->Form->input('log_id', ['options' => $logs, 'empty' => true]);
            echo $this->Form->input('url');
            echo $this->Form->input('params');
            echo $this->Form->input('query');
            echo $this->Form->input('data');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
