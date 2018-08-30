<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Content'), ['action' => 'edit', $content->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Content'), ['action' => 'delete', $content->id], ['confirm' => __('Are you sure you want to delete # {0}?', $content->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Content'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Category Contents'), ['controller' => 'CategoryContents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category Content'), ['controller' => 'CategoryContents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Meta Types'), ['controller' => 'MetaTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meta Type'), ['controller' => 'MetaTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Content Metas'), ['controller' => 'ContentMetas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Content Meta'), ['controller' => 'ContentMetas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contents view large-9 medium-8 columns content">
    <h3><?= h($content->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($content->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($content->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Image') ?></th>
            <td><?= h($content->image) ?></td>
        </tr>
        <tr>
            <th><?= __('Category Content') ?></th>
            <td><?= $content->has('category_content') ? $this->Html->link($content->category_content->id, ['controller' => 'CategoryContents', 'action' => 'view', $content->category_content->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Meta Type') ?></th>
            <td><?= $content->has('meta_type') ? $this->Html->link($content->meta_type->name, ['controller' => 'MetaTypes', 'action' => 'view', $content->meta_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($content->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Content Meta Id') ?></th>
            <td><?= $this->Number->format($content->content_meta_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($content->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($content->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Excerpt') ?></h4>
        <?= $this->Text->autoParagraph(h($content->excerpt)); ?>
    </div>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($content->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Content Metas') ?></h4>
        <?php if (!empty($content->content_metas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Key') ?></th>
                <th><?= __('Value') ?></th>
                <th><?= __('Content Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($content->content_metas as $contentMetas): ?>
            <tr>
                <td><?= h($contentMetas->id) ?></td>
                <td><?= h($contentMetas->key) ?></td>
                <td><?= h($contentMetas->value) ?></td>
                <td><?= h($contentMetas->content_id) ?></td>
                <td><?= h($contentMetas->created) ?></td>
                <td><?= h($contentMetas->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ContentMetas', 'action' => 'view', $contentMetas->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'ContentMetas', 'action' => 'edit', $contentMetas->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ContentMetas', 'action' => 'delete', $contentMetas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentMetas->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
