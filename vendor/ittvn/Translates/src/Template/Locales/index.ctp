<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Locale'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Translates'), ['controller' => 'Translates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Translate'), ['controller' => 'Translates', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="locales index large-9 medium-8 columns content">
    <h3><?= __('Locales') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('domain') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locales as $locale): ?>
            <tr>
                <td><?= $this->Number->format($locale->id) ?></td>
                <td><?= h($locale->domain) ?></td>
                <td><?= h($locale->created) ?></td>
                <td><?= h($locale->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $locale->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locale->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locale->id)]) ?>
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
