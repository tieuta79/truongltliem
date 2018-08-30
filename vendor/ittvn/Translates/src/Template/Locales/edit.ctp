<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $locale->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $locale->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Locales'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Translates'), ['controller' => 'Translates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Translate'), ['controller' => 'Translates', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="locales form large-9 medium-8 columns content">
    <?= $this->Form->create($locale) ?>
    <fieldset>
        <legend><?= __('Edit Locale') ?></legend>
        <?php
            echo $this->Form->input('msgid');
            echo $this->Form->input('domain');
            echo $this->Form->input('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
