<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Forms'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Fields'), ['controller' => 'Fields', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Field'), ['controller' => 'Fields', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="forms form large-9 medium-8 columns content">
    <?= $this->Form->create($form) ?>
    <fieldset>
        <legend><?= __('Add Form') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('slug');
            echo $this->Form->input('menu');
            echo $this->Form->input('list');
            echo $this->Form->input('before_submit');
            echo $this->Form->input('after_submit');
            echo $this->Form->input('js');
            echo $this->Form->input('css');
            echo $this->Form->input('delete');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
