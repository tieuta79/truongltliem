<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Meta'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="metas index large-9 medium-8 columns content">
    <h3><?= __('Metas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('model') ?></th>
                <th><?= $this->Paginator->sort('foreign_key') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('value') ?></th>
                <th><?= $this->Paginator->sort('type') ?></th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($metas as $meta): ?>
            <tr>
                <td><?= $this->Number->format($meta->id) ?></td>
                <td><?= h($meta->model) ?></td>
                <td><?= $this->Number->format($meta->foreign_key) ?></td>
                <td><?= h($meta->name) ?></td>
                <td><?= h($meta->value) ?></td>
                <td><?= h($meta->type) ?></td>
                <td><?= h($meta->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $meta->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $meta->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $meta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meta->id)]) ?>
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
