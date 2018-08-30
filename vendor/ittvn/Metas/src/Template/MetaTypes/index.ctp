<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Meta Type'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="metaTypes index large-9 medium-8 columns content">
    <h3><?= __('Meta Types') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('model') ?></th>
                <th><?= $this->Paginator->sort('menu') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($metaTypes as $metaType): ?>
            <tr>
                <td><?= $this->Number->format($metaType->id) ?></td>
                <td><?= h($metaType->name) ?></td>
                <td><?= h($metaType->slug) ?></td>
                <td><?= h($metaType->description) ?></td>
                <td><?= h($metaType->model) ?></td>
                <td><?= h($metaType->menu) ?></td>
                <td><?= h($metaType->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $metaType->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $metaType->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $metaType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $metaType->id)]) ?>
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
