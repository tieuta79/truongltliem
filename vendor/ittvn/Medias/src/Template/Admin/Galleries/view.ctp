<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Gallery'), ['action' => 'edit', $gallery->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Gallery'), ['action' => 'delete', $gallery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gallery->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Galleries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gallery'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Galleries'), ['controller' => 'Galleries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Gallery'), ['controller' => 'Galleries', 'action' => 'add']) ?> </li>
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
            <th><?= __('Parent Gallery') ?></th>
            <td><?= $gallery->has('parent_gallery') ? $this->Html->link($gallery->parent_gallery->name, ['controller' => 'Galleries', 'action' => 'view', $gallery->parent_gallery->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($gallery->id) ?></td>
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
        <h4><?= __('Related Galleries') ?></h4>
        <?php if (!empty($gallery->child_galleries)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Type') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Parent Id') ?></th>
                <th><?= __('Lft') ?></th>
                <th><?= __('Rght') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($gallery->child_galleries as $childGalleries): ?>
            <tr>
                <td><?= h($childGalleries->id) ?></td>
                <td><?= h($childGalleries->name) ?></td>
                <td><?= h($childGalleries->description) ?></td>
                <td><?= h($childGalleries->type) ?></td>
                <td><?= h($childGalleries->status) ?></td>
                <td><?= h($childGalleries->parent_id) ?></td>
                <td><?= h($childGalleries->lft) ?></td>
                <td><?= h($childGalleries->rght) ?></td>
                <td><?= h($childGalleries->created) ?></td>
                <td><?= h($childGalleries->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Galleries', 'action' => 'view', $childGalleries->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Galleries', 'action' => 'edit', $childGalleries->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Galleries', 'action' => 'delete', $childGalleries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childGalleries->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
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
