<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Meta Types'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="metaTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($metaType) ?>
    <fieldset>
        <legend><?= __('Add Meta Type') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('slug');
            echo $this->Form->input('description');
            echo $this->Form->input('model');
            echo $this->Form->input('menu');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
