<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Meta'), ['action' => 'edit', $meta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Meta'), ['action' => 'delete', $meta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Metas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meta'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="metas view large-9 medium-8 columns content">
    <h3><?= h($meta->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Model') ?></th>
            <td><?= h($meta->model) ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($meta->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Value') ?></th>
            <td><?= h($meta->value) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($meta->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($meta->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($meta->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($meta->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $meta->status ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="row">
        <h4><?= __('Options') ?></h4>
        <?= $this->Text->autoParagraph(h($meta->options)); ?>
    </div>
</div>
