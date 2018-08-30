<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Gallery'), ['action' => 'edit', $gallery->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Gallery'), ['action' => 'delete', $gallery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gallery->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Galleries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gallery'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Medias'), ['controller' => 'Medias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Media'), ['controller' => 'Medias', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="galleries view large-9 medium-8 columns content">
    <h3><?= h($gallery->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($gallery->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($gallery->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($gallery->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($gallery->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Parent Id') ?></th>
            <td><?= $this->Number->format($gallery->parent_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Lft') ?></th>
            <td><?= $this->Number->format($gallery->lft) ?></td>
        </tr>
        <tr>
            <th><?= __('Rght') ?></th>
            <td><?= $this->Number->format($gallery->rght) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($gallery->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($gallery->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $gallery->status ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Medias') ?></h4>
        <?php if (!empty($gallery->medias)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Url') ?></th>
                <th><?= __('Type') ?></th>
                <th><?= __('Size') ?></th>
                <th><?= __('Gallery Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($gallery->medias as $medias): ?>
            <tr>
                <td><?= h($medias->id) ?></td>
                <td><?= h($medias->name) ?></td>
                <td><?= h($medias->description) ?></td>
                <td><?= h($medias->url) ?></td>
                <td><?= h($medias->type) ?></td>
                <td><?= h($medias->size) ?></td>
                <td><?= h($medias->gallery_id) ?></td>
                <td><?= h($medias->created) ?></td>
                <td><?= h($medias->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Medias', 'action' => 'view', $medias->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Medias', 'action' => 'edit', $medias->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Medias', 'action' => 'delete', $medias->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medias->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
