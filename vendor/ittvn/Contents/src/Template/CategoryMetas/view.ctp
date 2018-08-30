<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Category Meta'), ['action' => 'edit', $categoryMeta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Category Meta'), ['action' => 'delete', $categoryMeta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoryMeta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Category Metas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category Meta'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="categoryMetas view large-9 medium-8 columns content">
    <h3><?= h($categoryMeta->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Key') ?></th>
            <td><?= h($categoryMeta->key) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($categoryMeta->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Category Id') ?></th>
            <td><?= $this->Number->format($categoryMeta->category_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($categoryMeta->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($categoryMeta->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Value') ?></h4>
        <?= $this->Text->autoParagraph(h($categoryMeta->value)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Categories') ?></h4>
        <?php if (!empty($categoryMeta->categories)): ?>
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
            <?php foreach ($categoryMeta->categories as $categories): ?>
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
