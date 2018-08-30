<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Domain'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sites'), ['controller' => 'Sites', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Site'), ['controller' => 'Sites', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="domains index large-9 medium-8 columns content">
    <h3><?= __('Domains') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('ip') ?></th>
                <th><?= $this->Paginator->sort('site_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($domains as $domain): ?>
            <tr>
                <td><?= $this->Number->format($domain->id) ?></td>
                <td><?= h($domain->name) ?></td>
                <td><?= h($domain->ip) ?></td>
                <td><?= $domain->has('site') ? $this->Html->link($domain->site->name, ['controller' => 'Sites', 'action' => 'view', $domain->site->id]) : '' ?></td>
                <td><?= h($domain->created) ?></td>
                <td><?= h($domain->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $domain->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $domain->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $domain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domain->id)]) ?>
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
