<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Meta Category'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Meta Types'), ['controller' => 'MetaTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meta Type'), ['controller' => 'MetaTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="metaCategories index large-9 medium-8 columns content">
    <h3><?= __('Meta Categories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('meta_type_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($metaCategories as $metaCategory): ?>
            <tr>
                <td><?= $this->Number->format($metaCategory->id) ?></td>
                <td><?= h($metaCategory->name) ?></td>
                <td><?= h($metaCategory->slug) ?></td>
                <td><?= h($metaCategory->description) ?></td>
                <td><?= $metaCategory->has('meta_type') ? $this->Html->link($metaCategory->meta_type->name, ['controller' => 'MetaTypes', 'action' => 'view', $metaCategory->meta_type->id]) : '' ?></td>
                <td><?= h($metaCategory->created) ?></td>
                <td><?= h($metaCategory->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $metaCategory->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $metaCategory->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $metaCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $metaCategory->id)]) ?>
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
