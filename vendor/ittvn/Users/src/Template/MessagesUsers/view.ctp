<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Messages User'), ['action' => 'edit', $messagesUser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Messages User'), ['action' => 'delete', $messagesUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $messagesUser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Messages Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Messages User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="messagesUsers view large-9 medium-8 columns content">
    <h3><?= h($messagesUser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $messagesUser->has('user') ? $this->Html->link($messagesUser->user->id, ['controller' => 'Users', 'action' => 'view', $messagesUser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Message') ?></th>
            <td><?= $messagesUser->has('message') ? $this->Html->link($messagesUser->message->title, ['controller' => 'Messages', 'action' => 'view', $messagesUser->message->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($messagesUser->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($messagesUser->date) ?></td>
        </tr>
        <tr>
            <th><?= __('Read') ?></th>
            <td><?= $messagesUser->read ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
