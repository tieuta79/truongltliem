<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Field'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Forms'), ['controller' => 'Forms', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Form'), ['controller' => 'Forms', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Field Metas'), ['controller' => 'FieldMetas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Field Meta'), ['controller' => 'FieldMetas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fields index large-9 medium-8 columns content">
    <h3><?= __('Fields') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th><?= $this->Paginator->sort('value') ?></th>
                <th><?= $this->Paginator->sort('type') ?></th>
                <th><?= $this->Paginator->sort('form_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fields as $field): ?>
            <tr>
                <td><?= $this->Number->format($field->id) ?></td>
                <td><?= h($field->name) ?></td>
                <td><?= h($field->slug) ?></td>
                <td><?= h($field->value) ?></td>
                <td><?= h($field->type) ?></td>
                <td><?= $field->has('form') ? $this->Html->link($field->form->name, ['controller' => 'Forms', 'action' => 'view', $field->form->id]) : '' ?></td>
                <td><?= h($field->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $field->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $field->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $field->id], ['confirm' => __('Are you sure you want to delete # {0}?', $field->id)]) ?>
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
