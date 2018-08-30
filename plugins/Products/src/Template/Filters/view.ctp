<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Filter'), ['action' => 'edit', $filter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Filter'), ['action' => 'delete', $filter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $filter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Filters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Filter'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="filters view large-9 medium-8 columns content">
    <h3><?= h($filter->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($filter->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($filter->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($filter->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($filter->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($filter->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($filter->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= $filter->delete ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="row">
        <h4><?= __('Attributes') ?></h4>
        <?= $this->Text->autoParagraph(h($filter->attributes)); ?>
    </div>
</div>
