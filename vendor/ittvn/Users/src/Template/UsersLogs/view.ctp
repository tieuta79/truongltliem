<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Users Log'), ['action' => 'edit', $usersLog->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Users Log'), ['action' => 'delete', $usersLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersLog->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users Logs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Users Log'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Logs'), ['controller' => 'Logs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Log'), ['controller' => 'Logs', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="usersLogs view large-9 medium-8 columns content">
    <h3><?= h($usersLog->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Log') ?></th>
            <td><?= $usersLog->has('log') ? $this->Html->link($usersLog->log->id, ['controller' => 'Logs', 'action' => 'view', $usersLog->log->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Url') ?></th>
            <td><?= h($usersLog->url) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($usersLog->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($usersLog->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($usersLog->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Params') ?></h4>
        <?= $this->Text->autoParagraph(h($usersLog->params)); ?>
    </div>
    <div class="row">
        <h4><?= __('Query') ?></h4>
        <?= $this->Text->autoParagraph(h($usersLog->query)); ?>
    </div>
    <div class="row">
        <h4><?= __('Data') ?></h4>
        <?= $this->Text->autoParagraph(h($usersLog->data)); ?>
    </div>
</div>
