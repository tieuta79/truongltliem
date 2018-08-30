<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User Meta'), ['action' => 'edit', $userMeta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Meta'), ['action' => 'delete', $userMeta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userMeta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Metas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Meta'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="userMetas view large-9 medium-8 columns content">
    <h3><?= h($userMeta->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Key') ?></th>
            <td><?= h($userMeta->key) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $userMeta->has('user') ? $this->Html->link($userMeta->user->id, ['controller' => 'Users', 'action' => 'view', $userMeta->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($userMeta->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($userMeta->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($userMeta->modified) ?></tr>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Value') ?></h4>
        <?= $this->Text->autoParagraph(h($userMeta->value)); ?>
    </div>
</div>
