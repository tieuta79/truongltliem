<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Parent Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Meta Categories'), ['controller' => 'MetaCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meta Category'), ['controller' => 'MetaCategories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Category Metas'), ['controller' => 'CategoryMetas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category Meta'), ['controller' => 'CategoryMetas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Category Contents'), ['controller' => 'CategoryContents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category Content'), ['controller' => 'CategoryContents', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="categories form large-9 medium-8 columns content">
    <?= $this->Form->create($category) ?>
    <fieldset>
        <legend><?= __('Add Category') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('slug');
            echo $this->Form->input('description');
            echo $this->Form->input('parent_id', ['options' => $parentCategories, 'empty' => true]);
            echo $this->Form->input('meta_category_id', ['options' => $metaCategories, 'empty' => true]);
            echo $this->Form->input('category_meta_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
