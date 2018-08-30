<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Fields'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Forms'), ['controller' => 'Forms', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Form'), ['controller' => 'Forms', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Field Metas'), ['controller' => 'FieldMetas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Field Meta'), ['controller' => 'FieldMetas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fields form large-9 medium-8 columns content">
    <?= $this->Form->create($field) ?>
    <fieldset>
        <legend><?= __('Add Field') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('slug');
            echo $this->Form->input('value');
            echo $this->Form->input('type');
            echo $this->Form->input('options');
            echo $this->Form->input('attributes');
            echo $this->Form->input('form_id', ['options' => $forms, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
