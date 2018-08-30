<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Content Metas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contentMetas form large-9 medium-8 columns content">
    <?= $this->Form->create($contentMeta) ?>
    <fieldset>
        <legend><?= __('Add Content Meta') ?></legend>
        <?php
            echo $this->Form->input('key');
            echo $this->Form->input('value');
            echo $this->Form->input('content_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
