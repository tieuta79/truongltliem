<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Message'), ['action' => 'edit', $message->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Message'), ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="messages view large-9 medium-8 columns content">
    <h3><?= h($message->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($message->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($message->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Priority') ?></th>
            <td><?= $this->Number->format($message->priority) ?></td>
        </tr>
        <tr>
            <th><?= __('Create') ?></th>
            <td><?= h($message->create) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($message->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= $message->email ? __('Yes') : __('No'); ?></td>
         </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= $message->delete ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($message->message)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($message->users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('First Name') ?></th>
                <th><?= __('Middle Name') ?></th>
                <th><?= __('Last Name') ?></th>
                <th><?= __('Username') ?></th>
                <th><?= __('Password') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Avatar') ?></th>
                <th><?= __('Sex') ?></th>
                <th><?= __('Birthday') ?></th>
                <th><?= __('Phone') ?></th>
                <th><?= __('Public Key') ?></th>
                <th><?= __('Private Key') ?></th>
                <th><?= __('Active Code') ?></th>
                <th><?= __('Role Id') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Delete') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($message->users as $users): ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->first_name) ?></td>
                <td><?= h($users->middle_name) ?></td>
                <td><?= h($users->last_name) ?></td>
                <td><?= h($users->username) ?></td>
                <td><?= h($users->password) ?></td>
                <td><?= h($users->email) ?></td>
                <td><?= h($users->avatar) ?></td>
                <td><?= h($users->sex) ?></td>
                <td><?= h($users->birthday) ?></td>
                <td><?= h($users->phone) ?></td>
                <td><?= h($users->public_key) ?></td>
                <td><?= h($users->private_key) ?></td>
                <td><?= h($users->active_code) ?></td>
                <td><?= h($users->role_id) ?></td>
                <td><?= h($users->status) ?></td>
                <td><?= h($users->delete) ?></td>
                <td><?= h($users->created) ?></td>
                <td><?= h($users->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
