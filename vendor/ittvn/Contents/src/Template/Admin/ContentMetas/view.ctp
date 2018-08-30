<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Content Meta'), ['action' => 'edit', $contentMeta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Content Meta'), ['action' => 'delete', $contentMeta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentMeta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Content Metas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Content Meta'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contentMetas view large-9 medium-8 columns content">
    <h3><?= h($contentMeta->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Key') ?></th>
            <td><?= h($contentMeta->key) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($contentMeta->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Content Id') ?></th>
            <td><?= $this->Number->format($contentMeta->content_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($contentMeta->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($contentMeta->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Value') ?></h4>
        <?= $this->Text->autoParagraph(h($contentMeta->value)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Contents') ?></h4>
        <?php if (!empty($contentMeta->contents)): ?>
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
            <?php foreach ($contentMeta->contents as $contents): ?>
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
