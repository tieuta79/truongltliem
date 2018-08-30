<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Category Meta'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="categoryMetas index large-9 medium-8 columns content">
    <h3><?= __('Category Metas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('key') ?></th>
                <th><?= $this->Paginator->sort('category_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoryMetas as $categoryMeta): ?>
            <tr>
                <td><?= $this->Number->format($categoryMeta->id) ?></td>
                <td><?= h($categoryMeta->key) ?></td>
                <td><?= $this->Number->format($categoryMeta->category_id) ?></td>
                <td><?= h($categoryMeta->created) ?></td>
                <td><?= h($categoryMeta->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $categoryMeta->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $categoryMeta->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $categoryMeta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoryMeta->id)]) ?>
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
