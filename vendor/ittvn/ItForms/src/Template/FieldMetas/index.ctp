<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Field Meta'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Fields'), ['controller' => 'Fields', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Field'), ['controller' => 'Fields', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fieldMetas index large-9 medium-8 columns content">
    <h3><?= __('Field Metas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('key') ?></th>
                <th><?= $this->Paginator->sort('field_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fieldMetas as $fieldMeta): ?>
            <tr>
                <td><?= $this->Number->format($fieldMeta->id) ?></td>
                <td><?= h($fieldMeta->key) ?></td>
                <td><?= $fieldMeta->has('field') ? $this->Html->link($fieldMeta->field->name, ['controller' => 'Fields', 'action' => 'view', $fieldMeta->field->id]) : '' ?></td>
                <td><?= h($fieldMeta->created) ?></td>
                <td><?= h($fieldMeta->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $fieldMeta->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $fieldMeta->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $fieldMeta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fieldMeta->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
