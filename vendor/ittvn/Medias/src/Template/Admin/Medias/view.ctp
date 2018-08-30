<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Media'), ['action' => 'edit', $media->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Media'), ['action' => 'delete', $media->id], ['confirm' => __('Are you sure you want to delete # {0}?', $media->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Medias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Media'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Galleries'), ['controller' => 'Galleries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gallery'), ['controller' => 'Galleries', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="medias view large-9 medium-8 columns content">
    <h3><?= h($media->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($media->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($media->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Url') ?></th>
            <td><?= h($media->url) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($media->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Gallery') ?></th>
            <td><?= $media->has('gallery') ? $this->Html->link($media->gallery->name, ['controller' => 'Galleries', 'action' => 'view', $media->gallery->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($media->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Size') ?></th>
            <td><?= $this->Number->format($media->size) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($media->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($media->modified) ?></td>
        </tr>
    </table>
</div>
