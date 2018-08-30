<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $redirecturl->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $redirecturl->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Redirecturls'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="redirecturls form large-9 medium-8 columns content">
    <?= $this->Form->create($redirecturl) ?>
    <fieldset>
        <legend><?= __('Edit Redirecturl') ?></legend>
        <?php
            echo $this->Form->input('request');
            echo $this->Form->input('target');
            echo $this->Form->input('options');
            echo $this->Form->input('delete');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
