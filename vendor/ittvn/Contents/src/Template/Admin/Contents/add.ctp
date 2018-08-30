<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Contents'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Category Contents'), ['controller' => 'CategoryContents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category Content'), ['controller' => 'CategoryContents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Meta Types'), ['controller' => 'MetaTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meta Type'), ['controller' => 'MetaTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Content Metas'), ['controller' => 'ContentMetas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content Meta'), ['controller' => 'ContentMetas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contents form large-9 medium-8 columns content">
    <?= $this->Form->create($content) ?>
    <fieldset>
        <legend><?= __('Add Content') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('slug');
            echo $this->Form->input('excerpt');
            echo $this->Form->input('description');
            echo $this->Form->input('image');
            echo $this->Form->input('category_content_id', ['options' => $categoryContents, 'empty' => true]);
            echo $this->Form->input('meta_type_id', ['options' => $metaTypes, 'empty' => true]);
            echo $this->Form->input('content_meta_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
