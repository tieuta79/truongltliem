<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Users Log'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Logs'), ['controller' => 'Logs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Log'), ['controller' => 'Logs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usersLogs index large-9 medium-8 columns content">
    <h3><?= __('Users Logs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('log_id') ?></th>
                <th><?= $this->Paginator->sort('url') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersLogs as $usersLog): ?>
            <tr>
                <td><?= $this->Number->format($usersLog->id) ?></td>
                <td><?= $usersLog->has('log') ? $this->Html->link($usersLog->log->id, ['controller' => 'Logs', 'action' => 'view', $usersLog->log->id]) : '' ?></td>
                <td><?= h($usersLog->url) ?></td>
                <td><?= h($usersLog->created) ?></td>
                <td><?= h($usersLog->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $usersLog->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $usersLog->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $usersLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersLog->id)]) ?>
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
