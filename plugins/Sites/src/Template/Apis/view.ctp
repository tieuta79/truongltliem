<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Api'), ['action' => 'edit', $api->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Api'), ['action' => 'delete', $api->id], ['confirm' => __('Are you sure you want to delete # {0}?', $api->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Apis'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Api'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="apis view large-9 medium-8 columns content">
    <h3><?= h($api->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($api->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($api->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Method') ?></th>
            <td><?= h($api->method) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($api->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($api->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($api->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $api->status ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
