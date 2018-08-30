<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $language->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $language->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Languages'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="languages form large-9 medium-8 columns content">
    <?= $this->Form->create($language) ?>
    <fieldset>
        <legend><?= __('Edit Language') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('code');
            echo $this->Form->input('image');
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
