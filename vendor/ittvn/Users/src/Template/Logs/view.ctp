<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Log'), ['action' => 'edit', $log->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Log'), ['action' => 'delete', $log->id], ['confirm' => __('Are you sure you want to delete # {0}?', $log->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Logs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Log'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="logs view large-9 medium-8 columns content">
    <h3><?= h($log->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $log->has('user') ? $this->Html->link($log->user->id, ['controller' => 'Users', 'action' => 'view', $log->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Ip') ?></th>
            <td><?= h($log->ip) ?></td>
        </tr>
        <tr>
            <th><?= __('Browser') ?></th>
            <td><?= h($log->browser) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($log->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Create') ?></th>
            <td><?= h($log->create) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($log->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= $log->delete ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
