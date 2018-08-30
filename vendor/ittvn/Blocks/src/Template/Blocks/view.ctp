<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Block'), ['action' => 'edit', $block->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Block'), ['action' => 'delete', $block->id], ['confirm' => __('Are you sure you want to delete # {0}?', $block->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Blocks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Block'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="blocks view large-9 medium-8 columns content">
    <h3><?= h($block->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($block->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($block->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($block->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($block->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($block->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= $block->delete ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="row">
        <h4><?= __('Html') ?></h4>
        <?= $this->Text->autoParagraph(h($block->html)); ?>
    </div>
</div>
