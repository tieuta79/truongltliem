<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Translates'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Languages'), ['controller' => 'Languages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Language'), ['controller' => 'Languages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locales'), ['controller' => 'Locales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Locale'), ['controller' => 'Locales', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="translates form large-9 medium-8 columns content">
    <?= $this->Form->create($translate) ?>
    <fieldset>
        <legend><?= __('Add Translate') ?></legend>
        <?php
            echo $this->Form->input('language_id', ['options' => $languages, 'empty' => true]);
            echo $this->Form->input('locale_id', ['options' => $locales, 'empty' => true]);
            echo $this->Form->input('msgstr');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
