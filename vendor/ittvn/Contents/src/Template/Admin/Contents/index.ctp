<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Content'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Category Contents'), ['controller' => 'CategoryContents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category Content'), ['controller' => 'CategoryContents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Meta Types'), ['controller' => 'MetaTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meta Type'), ['controller' => 'MetaTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Content Metas'), ['controller' => 'ContentMetas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content Meta'), ['controller' => 'ContentMetas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contents index large-9 medium-8 columns content">
    <h3><?= __('Contents') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th><?= $this->Paginator->sort('image') ?></th>
                <th><?= $this->Paginator->sort('category_content_id') ?></th>
                <th><?= $this->Paginator->sort('meta_type_id') ?></th>
                <th><?= $this->Paginator->sort('content_meta_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contents as $content): ?>
            <tr>
                <td><?= $this->Number->format($content->id) ?></td>
                <td><?= h($content->name) ?></td>
                <td><?= h($content->slug) ?></td>
                <td><?= h($content->image) ?></td>
                <td><?= $content->has('category_content') ? $this->Html->link($content->category_content->id, ['controller' => 'CategoryContents', 'action' => 'view', $content->category_content->id]) : '' ?></td>
                <td><?= $content->has('meta_type') ? $this->Html->link($content->meta_type->name, ['controller' => 'MetaTypes', 'action' => 'view', $content->meta_type->id]) : '' ?></td>
                <td><?= $this->Number->format($content->content_meta_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $content->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $content->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $content->id], ['confirm' => __('Are you sure you want to delete # {0}?', $content->id)]) ?>
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
