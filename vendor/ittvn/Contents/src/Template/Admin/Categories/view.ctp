<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Meta Categories'), ['controller' => 'MetaCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meta Category'), ['controller' => 'MetaCategories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Category Metas'), ['controller' => 'CategoryMetas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category Meta'), ['controller' => 'CategoryMetas', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Category Contents'), ['controller' => 'CategoryContents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category Content'), ['controller' => 'CategoryContents', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="categories view large-9 medium-8 columns content">
    <h3><?= h($category->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($category->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($category->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Parent Category') ?></th>
            <td><?= $category->has('parent_category') ? $this->Html->link($category->parent_category->name, ['controller' => 'Categories', 'action' => 'view', $category->parent_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Meta Category') ?></th>
            <td><?= $category->has('meta_category') ? $this->Html->link($category->meta_category->name, ['controller' => 'MetaCategories', 'action' => 'view', $category->meta_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($category->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Lft') ?></th>
            <td><?= $this->Number->format($category->lft) ?></td>
        </tr>
        <tr>
            <th><?= __('Rght') ?></th>
            <td><?= $this->Number->format($category->rght) ?></td>
        </tr>
        <tr>
            <th><?= __('Category Meta Id') ?></th>
            <td><?= $this->Number->format($category->category_meta_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($category->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($category->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Category Metas') ?></h4>
        <?php if (!empty($category->category_metas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Key') ?></th>
                <th><?= __('Value') ?></th>
                <th><?= __('Category Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($category->category_metas as $categoryMetas): ?>
            <tr>
                <td><?= h($categoryMetas->id) ?></td>
                <td><?= h($categoryMetas->key) ?></td>
                <td><?= h($categoryMetas->value) ?></td>
                <td><?= h($categoryMetas->category_id) ?></td>
                <td><?= h($categoryMetas->created) ?></td>
                <td><?= h($categoryMetas->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CategoryMetas', 'action' => 'view', $categoryMetas->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'CategoryMetas', 'action' => 'edit', $categoryMetas->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CategoryMetas', 'action' => 'delete', $categoryMetas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoryMetas->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Categories') ?></h4>
        <?php if (!empty($category->child_categories)): ?>
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
            <?php foreach ($category->child_categories as $childCategories): ?>
            <tr>
                <td><?= h($childCategories->id) ?></td>
                <td><?= h($childCategories->name) ?></td>
                <td><?= h($childCategories->slug) ?></td>
                <td><?= h($childCategories->description) ?></td>
                <td><?= h($childCategories->parent_id) ?></td>
                <td><?= h($childCategories->lft) ?></td>
                <td><?= h($childCategories->rght) ?></td>
                <td><?= h($childCategories->meta_category_id) ?></td>
                <td><?= h($childCategories->category_meta_id) ?></td>
                <td><?= h($childCategories->created) ?></td>
                <td><?= h($childCategories->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Categories', 'action' => 'view', $childCategories->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Categories', 'action' => 'edit', $childCategories->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Categories', 'action' => 'delete', $childCategories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childCategories->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Category Contents') ?></h4>
        <?php if (!empty($category->category_contents)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Content Id') ?></th>
                <th><?= __('Category Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($category->category_contents as $categoryContents): ?>
            <tr>
                <td><?= h($categoryContents->id) ?></td>
                <td><?= h($categoryContents->content_id) ?></td>
                <td><?= h($categoryContents->category_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CategoryContents', 'action' => 'view', $categoryContents->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'CategoryContents', 'action' => 'edit', $categoryContents->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CategoryContents', 'action' => 'delete', $categoryContents->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoryContents->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
