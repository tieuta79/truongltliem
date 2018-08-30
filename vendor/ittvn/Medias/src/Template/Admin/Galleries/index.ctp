<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Gallery'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Medias'), ['controller' => 'Medias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Media'), ['controller' => 'Medias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="galleries index large-9 medium-8 columns content">
    <h3><?= __('Galleries') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('type') ?></th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th><?= $this->Paginator->sort('parent_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($galleries as $gallery): ?>
            <tr>
                <td><?= $this->Number->format($gallery->id) ?></td>
                <td><?= h($gallery->name) ?></td>
                <td><?= h($gallery->description) ?></td>
                <td><?= h($gallery->type) ?></td>
                <td><?= h($gallery->status) ?></td>
                <td><?= $gallery->has('parent_gallery') ? $this->Html->link($gallery->parent_gallery->name, ['controller' => 'Galleries', 'action' => 'view', $gallery->parent_gallery->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $gallery->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $gallery->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $gallery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gallery->id)]) ?>
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
