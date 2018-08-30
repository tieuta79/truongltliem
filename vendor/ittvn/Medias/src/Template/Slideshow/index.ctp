<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Slideshow'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Galleries'), ['controller' => 'Galleries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Gallery'), ['controller' => 'Galleries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="slideshow index large-9 medium-8 columns content">
    <h3><?= __('Slideshow') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th><?= $this->Paginator->sort('gallery_id') ?></th>
                <th><?= $this->Paginator->sort('category_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($slideshow as $slideshow): ?>
            <tr>
                <td><?= $this->Number->format($slideshow->id) ?></td>
                <td><?= h($slideshow->name) ?></td>
                <td><?= h($slideshow->slug) ?></td>
                <td><?= $slideshow->has('gallery') ? $this->Html->link($slideshow->gallery->name, ['controller' => 'Galleries', 'action' => 'view', $slideshow->gallery->id]) : '' ?></td>
                <td><?= $slideshow->has('category') ? $this->Html->link($slideshow->category->name, ['controller' => 'Categories', 'action' => 'view', $slideshow->category->id]) : '' ?></td>
                <td><?= h($slideshow->created) ?></td>
                <td><?= h($slideshow->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $slideshow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $slideshow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $slideshow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $slideshow->id)]) ?>
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
