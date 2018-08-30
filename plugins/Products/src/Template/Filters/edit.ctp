<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $filter->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $filter->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Filters'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="filters form large-9 medium-8 columns content">
    <?= $this->Form->create($filter) ?>
    <fieldset>
        <legend><?= __('Edit Filter') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('slug');
            echo $this->Form->input('description');
            echo $this->Form->input('attributes');
            echo $this->Form->input('delete');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
