<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Messages User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="messagesUsers index large-9 medium-8 columns content">
    <h3><?= __('Messages Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('message_id') ?></th>
                <th><?= $this->Paginator->sort('read') ?></th>
                <th><?= $this->Paginator->sort('date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messagesUsers as $messagesUser): ?>
            <tr>
                <td><?= $this->Number->format($messagesUser->id) ?></td>
                <td><?= $messagesUser->has('user') ? $this->Html->link($messagesUser->user->id, ['controller' => 'Users', 'action' => 'view', $messagesUser->user->id]) : '' ?></td>
                <td><?= $messagesUser->has('message') ? $this->Html->link($messagesUser->message->title, ['controller' => 'Messages', 'action' => 'view', $messagesUser->message->id]) : '' ?></td>
                <td><?= h($messagesUser->read) ?></td>
                <td><?= h($messagesUser->date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $messagesUser->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $messagesUser->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $messagesUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $messagesUser->id)]) ?>
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
