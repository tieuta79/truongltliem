<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Menu'), ['action' => 'edit', $menu->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Menu'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Menus'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Menu'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Menutypes'), ['controller' => 'Menutypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Menutype'), ['controller' => 'Menutypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="menus view large-9 medium-8 columns content">
    <h3><?= h($menu->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($menu->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($menu->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($menu->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Url') ?></th>
            <td><?= h($menu->url) ?></td>
        </tr>
        <tr>
            <th><?= __('Category') ?></th>
            <td><?= $menu->has('category') ? $this->Html->link($menu->category->name, ['controller' => 'Categories', 'action' => 'view', $menu->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Content') ?></th>
            <td><?= $menu->has('content') ? $this->Html->link($menu->content->name, ['controller' => 'Contents', 'action' => 'view', $menu->content->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Menutype') ?></th>
            <td><?= $menu->has('menutype') ? $this->Html->link($menu->menutype->name, ['controller' => 'Menutypes', 'action' => 'view', $menu->menutype->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($menu->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($menu->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($menu->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Attributes') ?></h4>
        <?= $this->Text->autoParagraph(h($menu->attributes)); ?>
    </div>
</div>
