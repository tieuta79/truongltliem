<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Domains'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sites'), ['controller' => 'Sites', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Site'), ['controller' => 'Sites', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="domains form large-9 medium-8 columns content">
    <?= $this->Form->create($domain) ?>
    <fieldset>
        <legend><?= __('Add Domain') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('ip');
            echo $this->Form->input('site_id', ['options' => $sites, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
