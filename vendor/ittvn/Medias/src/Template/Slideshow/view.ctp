<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Slideshow'), ['action' => 'edit', $slideshow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Slideshow'), ['action' => 'delete', $slideshow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $slideshow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Slideshow'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Slideshow'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Galleries'), ['controller' => 'Galleries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gallery'), ['controller' => 'Galleries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="slideshow view large-9 medium-8 columns content">
    <h3><?= h($slideshow->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($slideshow->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($slideshow->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Gallery') ?></th>
            <td><?= $slideshow->has('gallery') ? $this->Html->link($slideshow->gallery->name, ['controller' => 'Galleries', 'action' => 'view', $slideshow->gallery->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Category') ?></th>
            <td><?= $slideshow->has('category') ? $this->Html->link($slideshow->category->name, ['controller' => 'Categories', 'action' => 'view', $slideshow->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($slideshow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($slideshow->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($slideshow->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($slideshow->content)); ?>
    </div>
    <div class="row">
        <h4><?= __('Config') ?></h4>
        <?= $this->Text->autoParagraph(h($slideshow->config)); ?>
    </div>
</div>
