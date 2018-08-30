<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Category Content'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="categoryContents index large-9 medium-8 columns content">
    <h3><?= __('Category Contents') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('content_id') ?></th>
                <th><?= $this->Paginator->sort('category_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoryContents as $categoryContent): ?>
            <tr>
                <td><?= $this->Number->format($categoryContent->id) ?></td>
                <td><?= $this->Number->format($categoryContent->content_id) ?></td>
                <td><?= $categoryContent->has('category') ? $this->Html->link($categoryContent->category->name, ['controller' => 'Categories', 'action' => 'view', $categoryContent->category->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $categoryContent->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $categoryContent->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $categoryContent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoryContent->id)]) ?>
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
