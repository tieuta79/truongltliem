<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Meta Category'), ['action' => 'edit', $metaCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Meta Category'), ['action' => 'delete', $metaCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $metaCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Meta Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meta Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Meta Types'), ['controller' => 'MetaTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meta Type'), ['controller' => 'MetaTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="metaCategories view large-9 medium-8 columns content">
    <h3><?= h($metaCategory->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($metaCategory->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($metaCategory->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($metaCategory->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Meta Type') ?></th>
            <td><?= $metaCategory->has('meta_type') ? $this->Html->link($metaCategory->meta_type->name, ['controller' => 'MetaTypes', 'action' => 'view', $metaCategory->meta_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($metaCategory->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($metaCategory->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($metaCategory->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Categories') ?></h4>
        <?php if (!empty($metaCategory->categories)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Slug') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Parent Id') ?></th>
                <th><?= __('Lft') ?></th>
                <th><?= __('Rght') ?></th>
                <th><?= __('Meta Category Id') ?></th>
                <th><?= __('Category Meta Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($metaCategory->categories as $categories): ?>
            <tr>
                <td><?= h($categories->id) ?></td>
                <td><?= h($categories->name) ?></td>
                <td><?= h($categories->slug) ?></td>
                <td><?= h($categories->description) ?></td>
                <td><?= h($categories->parent_id) ?></td>
                <td><?= h($categories->lft) ?></td>
                <td><?= h($categories->rght) ?></td>
                <td><?= h($categories->meta_category_id) ?></td>
                <td><?= h($categories->category_meta_id) ?></td>
                <td><?= h($categories->created) ?></td>
                <td><?= h($categories->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Categories', 'action' => 'view', $categories->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Categories', 'action' => 'edit', $categories->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Categories', 'action' => 'delete', $categories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categories->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
