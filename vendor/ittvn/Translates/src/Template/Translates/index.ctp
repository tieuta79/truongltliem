<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Translate'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Languages'), ['controller' => 'Languages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Language'), ['controller' => 'Languages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locales'), ['controller' => 'Locales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Locale'), ['controller' => 'Locales', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="translates index large-9 medium-8 columns content">
    <h3><?= __('Translates') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('language_id') ?></th>
                <th><?= $this->Paginator->sort('locale_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($translates as $translate): ?>
            <tr>
                <td><?= $this->Number->format($translate->id) ?></td>
                <td><?= $translate->has('language') ? $this->Html->link($translate->language->name, ['controller' => 'Languages', 'action' => 'view', $translate->language->id]) : '' ?></td>
                <td><?= $translate->has('locale') ? $this->Html->link($translate->locale->id, ['controller' => 'Locales', 'action' => 'view', $translate->locale->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $translate->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $translate->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $translate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $translate->id)]) ?>
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
