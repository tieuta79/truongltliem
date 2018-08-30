<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User Meta'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="userMetas index large-9 medium-8 columns content">
    <h3><?= __('User Metas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('key') ?></th>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userMetas as $userMeta): ?>
            <tr>
                <td><?= $this->Number->format($userMeta->id) ?></td>
                <td><?= h($userMeta->key) ?></td>
                <td><?= $userMeta->has('user') ? $this->Html->link($userMeta->user->id, ['controller' => 'Users', 'action' => 'view', $userMeta->user->id]) : '' ?></td>
                <td><?= h($userMeta->created) ?></td>
                <td><?= h($userMeta->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $userMeta->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userMeta->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userMeta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userMeta->id)]) ?>
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
