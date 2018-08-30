<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Meta Categories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Meta Types'), ['controller' => 'MetaTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meta Type'), ['controller' => 'MetaTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="metaCategories form large-9 medium-8 columns content">
    <?= $this->Form->create($metaCategory) ?>
    <fieldset>
        <legend><?= __('Add Meta Category') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('slug');
            echo $this->Form->input('description');
            echo $this->Form->input('meta_type_id', ['options' => $metaTypes, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
