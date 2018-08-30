<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contentMeta->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contentMeta->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Content Metas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contentMetas form large-9 medium-8 columns content">
    <?= $this->Form->create($contentMeta) ?>
    <fieldset>
        <legend><?= __('Edit Content Meta') ?></legend>
        <?php
            echo $this->Form->input('key');
            echo $this->Form->input('value');
            echo $this->Form->input('content_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
