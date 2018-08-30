<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Category Content'), ['action' => 'edit', $categoryContent->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Category Content'), ['action' => 'delete', $categoryContent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoryContent->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Category Contents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category Content'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="categoryContents view large-9 medium-8 columns content">
    <h3><?= h($categoryContent->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Category') ?></th>
            <td><?= $categoryContent->has('category') ? $this->Html->link($categoryContent->category->name, ['controller' => 'Categories', 'action' => 'view', $categoryContent->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($categoryContent->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Content Id') ?></th>
            <td><?= $this->Number->format($categoryContent->content_id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Contents') ?></h4>
        <?php if (!empty($categoryContent->contents)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Slug') ?></th>
                <th><?= __('Excerpt') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Image') ?></th>
                <th><?= __('Category Content Id') ?></th>
                <th><?= __('Meta Type Id') ?></th>
                <th><?= __('Content Meta Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($categoryContent->contents as $contents): ?>
            <tr>
                <td><?= h($contents->id) ?></td>
                <td><?= h($contents->name) ?></td>
                <td><?= h($contents->slug) ?></td>
                <td><?= h($contents->excerpt) ?></td>
                <td><?= h($contents->description) ?></td>
                <td><?= h($contents->image) ?></td>
                <td><?= h($contents->category_content_id) ?></td>
                <td><?= h($contents->meta_type_id) ?></td>
                <td><?= h($contents->content_meta_id) ?></td>
                <td><?= h($contents->created) ?></td>
                <td><?= h($contents->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Contents', 'action' => 'view', $contents->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Contents', 'action' => 'edit', $contents->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Contents', 'action' => 'delete', $contents->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contents->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
