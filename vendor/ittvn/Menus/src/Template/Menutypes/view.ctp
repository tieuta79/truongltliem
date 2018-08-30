<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Menutype'), ['action' => 'edit', $menutype->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Menutype'), ['action' => 'delete', $menutype->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menutype->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Menutypes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Menutype'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Menus'), ['controller' => 'Menus', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Menu'), ['controller' => 'Menus', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="menutypes view large-9 medium-8 columns content">
    <h3><?= h($menutype->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($menutype->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($menutype->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($menutype->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($menutype->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($menutype->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($menutype->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Menus') ?></h4>
        <?php if (!empty($menutype->menus)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Slug') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Url') ?></th>
                <th><?= __('Category Id') ?></th>
                <th><?= __('Content Id') ?></th>
                <th><?= __('Menutype Id') ?></th>
                <th><?= __('Attributes') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($menutype->menus as $menus): ?>
            <tr>
                <td><?= h($menus->id) ?></td>
                <td><?= h($menus->name) ?></td>
                <td><?= h($menus->slug) ?></td>
                <td><?= h($menus->description) ?></td>
                <td><?= h($menus->url) ?></td>
                <td><?= h($menus->category_id) ?></td>
                <td><?= h($menus->content_id) ?></td>
                <td><?= h($menus->menutype_id) ?></td>
                <td><?= h($menus->attributes) ?></td>
                <td><?= h($menus->created) ?></td>
                <td><?= h($menus->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Menus', 'action' => 'view', $menus->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Menus', 'action' => 'edit', $menus->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Menus', 'action' => 'delete', $menus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menus->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
