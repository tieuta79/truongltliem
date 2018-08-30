<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Meta Type'), ['action' => 'edit', $metaType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Meta Type'), ['action' => 'delete', $metaType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $metaType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Meta Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meta Type'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="metaTypes view large-9 medium-8 columns content">
    <h3><?= h($metaType->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($metaType->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($metaType->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($metaType->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Model') ?></th>
            <td><?= h($metaType->model) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($metaType->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($metaType->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($metaType->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Menu') ?></th>
            <td><?= $metaType->menu ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
