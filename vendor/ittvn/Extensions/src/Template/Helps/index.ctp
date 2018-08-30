<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Help'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="helps index large-9 medium-8 columns content">
    <h3><?= __('Helps') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('link') ?></th>
                <th><?= $this->Paginator->sort('delete') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($helps as $help): ?>
            <tr>
                <td><?= $this->Number->format($help->id) ?></td>
                <td><?= h($help->link) ?></td>
                <td><?= h($help->delete) ?></td>
                <td><?= h($help->created) ?></td>
                <td><?= h($help->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $help->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $help->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $help->id], ['confirm' => __('Are you sure you want to delete # {0}?', $help->id)]) ?>
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
