<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Api'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="apis index large-9 medium-8 columns content">
    <h3><?= __('Apis') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('method') ?></th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($apis as $api): ?>
            <tr>
                <td><?= $this->Number->format($api->id) ?></td>
                <td><?= h($api->name) ?></td>
                <td><?= h($api->description) ?></td>
                <td><?= h($api->method) ?></td>
                <td><?= h($api->status) ?></td>
                <td><?= h($api->created) ?></td>
                <td><?= h($api->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $api->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $api->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $api->id], ['confirm' => __('Are you sure you want to delete # {0}?', $api->id)]) ?>
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
