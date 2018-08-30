<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Field Meta'), ['action' => 'edit', $fieldMeta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Field Meta'), ['action' => 'delete', $fieldMeta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fieldMeta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Field Metas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Field Meta'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Fields'), ['controller' => 'Fields', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Field'), ['controller' => 'Fields', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fieldMetas view large-9 medium-8 columns content">
    <h3><?= h($fieldMeta->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Key') ?></th>
            <td><?= h($fieldMeta->key) ?></td>
        </tr>
        <tr>
            <th><?= __('Field') ?></th>
            <td><?= $fieldMeta->has('field') ? $this->Html->link($fieldMeta->field->name, ['controller' => 'Fields', 'action' => 'view', $fieldMeta->field->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($fieldMeta->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($fieldMeta->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($fieldMeta->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Value') ?></h4>
        <?= $this->Text->autoParagraph(h($fieldMeta->value)); ?>
    </div>
</div>
