<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Help'), ['action' => 'edit', $help->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Help'), ['action' => 'delete', $help->id], ['confirm' => __('Are you sure you want to delete # {0}?', $help->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Helps'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Help'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="helps view large-9 medium-8 columns content">
    <h3><?= h($help->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Link') ?></th>
            <td><?= h($help->link) ?></td>
        </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= h($help->delete) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($help->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($help->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($help->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($help->content)); ?>
    </div>
</div>
