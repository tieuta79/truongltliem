<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Site'), ['action' => 'edit', $site->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Site'), ['action' => 'delete', $site->id], ['confirm' => __('Are you sure you want to delete # {0}?', $site->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sites'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Site'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sites view large-9 medium-8 columns content">
    <h3><?= h($site->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($site->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($site->description) ?></td>
        </tr>
        <tr>
            <th><?= __('PublicKey') ?></th>
            <td><?= h($site->publicKey) ?></td>
        </tr>
        <tr>
            <th><?= __('PrivateKey') ?></th>
            <td><?= h($site->privateKey) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $site->has('user') ? $this->Html->link($site->user->id, ['controller' => 'Users', 'action' => 'view', $site->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($site->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($site->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($site->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $site->status ? __('Yes') : __('No'); ?></td>
         </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= $site->delete ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="row">
        <h4><?= __('Database') ?></h4>
        <?= $this->Text->autoParagraph(h($site->database)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Domains') ?></h4>
        <?php if (!empty($site->domains)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Ip') ?></th>
                <th><?= __('Site Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($site->domains as $domains): ?>
            <tr>
                <td><?= h($domains->id) ?></td>
                <td><?= h($domains->name) ?></td>
                <td><?= h($domains->ip) ?></td>
                <td><?= h($domains->site_id) ?></td>
                <td><?= h($domains->created) ?></td>
                <td><?= h($domains->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Domains', 'action' => 'view', $domains->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Domains', 'action' => 'edit', $domains->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Domains', 'action' => 'delete', $domains->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domains->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
