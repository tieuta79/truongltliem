<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Content Meta'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contentMetas index large-9 medium-8 columns content">
    <h3><?= __('Content Metas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('key') ?></th>
                <th><?= $this->Paginator->sort('content_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contentMetas as $contentMeta): ?>
            <tr>
                <td><?= $this->Number->format($contentMeta->id) ?></td>
                <td><?= h($contentMeta->key) ?></td>
                <td><?= $this->Number->format($contentMeta->content_id) ?></td>
                <td><?= h($contentMeta->created) ?></td>
                <td><?= h($contentMeta->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contentMeta->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contentMeta->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contentMeta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentMeta->id)]) ?>
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
