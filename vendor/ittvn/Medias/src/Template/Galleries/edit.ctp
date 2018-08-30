<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $gallery->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $gallery->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Galleries'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Medias'), ['controller' => 'Medias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Media'), ['controller' => 'Medias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="galleries form large-9 medium-8 columns content">
    <?= $this->Form->create($gallery) ?>
    <fieldset>
        <legend><?= __('Edit Gallery') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            echo $this->Form->input('type');
            echo $this->Form->input('status');
            echo $this->Form->input('parent_id');
            echo $this->Form->input('lft');
            echo $this->Form->input('rght');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
