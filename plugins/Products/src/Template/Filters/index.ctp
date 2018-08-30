<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Filter'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="filters index large-9 medium-8 columns content">
    <h3><?= __('Filters') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('delete') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filters as $filter): ?>
            <tr>
                <td><?= $this->Number->format($filter->id) ?></td>
                <td><?= h($filter->name) ?></td>
                <td><?= h($filter->slug) ?></td>
                <td><?= h($filter->description) ?></td>
                <td><?= h($filter->delete) ?></td>
                <td><?= h($filter->created) ?></td>
                <td><?= h($filter->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $filter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $filter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $filter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $filter->id)]) ?>
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
