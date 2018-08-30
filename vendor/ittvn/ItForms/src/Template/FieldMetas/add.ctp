<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Field Metas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Fields'), ['controller' => 'Fields', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Field'), ['controller' => 'Fields', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fieldMetas form large-9 medium-8 columns content">
    <?= $this->Form->create($fieldMeta) ?>
    <fieldset>
        <legend><?= __('Add Field Meta') ?></legend>
        <?php
            echo $this->Form->input('key');
            echo $this->Form->input('value');
            echo $this->Form->input('field_id', ['options' => $fields, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
