<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Apis'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="apis form large-9 medium-8 columns content">
    <?= $this->Form->create($api) ?>
    <fieldset>
        <legend><?= __('Add Api') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            echo $this->Form->input('method');
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
