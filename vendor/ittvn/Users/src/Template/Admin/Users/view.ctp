<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Metas'), ['controller' => 'UserMetas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Meta'), ['controller' => 'UserMetas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Middle Name') ?></th>
            <td><?= h($user->middle_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Avatar') ?></th>
            <td><?= h($user->avatar) ?></td>
        </tr>
        <tr>
            <th><?= __('Phone') ?></th>
            <td><?= h($user->phone) ?></td>
        </tr>
        <tr>
            <th><?= __('Public Key') ?></th>
            <td><?= h($user->public_key) ?></td>
        </tr>
        <tr>
            <th><?= __('Private Key') ?></th>
            <td><?= h($user->private_key) ?></td>
        </tr>
        <tr>
            <th><?= __('Active Code') ?></th>
            <td><?= h($user->active_code) ?></td>
        </tr>
        <tr>
            <th><?= __('Role') ?></th>
            <td><?= $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></tr>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $user->status ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="related">
        <h4><?= __('Related User Metas') ?></h4>
        <?php if (!empty($user->user_metas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Key') ?></th>
                <th><?= __('Value') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->user_metas as $userMetas): ?>
            <tr>
                <td><?= h($userMetas->id) ?></td>
                <td><?= h($userMetas->key) ?></td>
                <td><?= h($userMetas->value) ?></td>
                <td><?= h($userMetas->user_id) ?></td>
                <td><?= h($userMetas->created) ?></td>
                <td><?= h($userMetas->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UserMetas', 'action' => 'view', $userMetas->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserMetas', 'action' => 'edit', $userMetas->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserMetas', 'action' => 'delete', $userMetas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userMetas->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
