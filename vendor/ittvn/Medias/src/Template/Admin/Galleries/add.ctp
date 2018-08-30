<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Galleries'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Parent Galleries'), ['controller' => 'Galleries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent Gallery'), ['controller' => 'Galleries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Medias'), ['controller' => 'Medias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Media'), ['controller' => 'Medias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="galleries form large-9 medium-8 columns content">
    <?= $this->Form->create($gallery) ?>
    <fieldset>
        <legend><?= __('Add Gallery') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            echo $this->Form->input('type');
            echo $this->Form->input('status');
            echo $this->Form->input('parent_id', ['options' => $parentGalleries, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
