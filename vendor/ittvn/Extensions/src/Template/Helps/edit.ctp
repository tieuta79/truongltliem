<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $help->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $help->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Helps'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="helps form large-9 medium-8 columns content">
    <?= $this->Form->create($help) ?>
    <fieldset>
        <legend><?= __('Edit Help') ?></legend>
        <?php
            echo $this->Form->input('content');
            echo $this->Form->input('link');
            echo $this->Form->input('delete');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
