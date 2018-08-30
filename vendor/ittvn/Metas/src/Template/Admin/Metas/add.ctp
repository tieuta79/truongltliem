<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Metas'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="metas form large-9 medium-8 columns content">
    <?= $this->Form->create($meta) ?>
    <fieldset>
        <legend><?= __('Add Meta') ?></legend>
        <?php
            echo $this->Form->input('model');
            echo $this->Form->input('name');
            echo $this->Form->input('value');
            echo $this->Form->input('type');
            echo $this->Form->input('options');
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
