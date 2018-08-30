<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Attribute Product'), ['action' => 'edit', $attributeProduct->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Attribute Product'), ['action' => 'delete', $attributeProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attributeProduct->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Attribute Products'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Attribute Product'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Attributes'), ['controller' => 'Attributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Attribute'), ['controller' => 'Attributes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="attributeProducts view large-9 medium-8 columns content">
    <h3><?= h($attributeProduct->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Content') ?></th>
            <td><?= $attributeProduct->has('content') ? $this->Html->link($attributeProduct->content->name, ['controller' => 'Contents', 'action' => 'view', $attributeProduct->content->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Attribute') ?></th>
            <td><?= $attributeProduct->has('attribute') ? $this->Html->link($attributeProduct->attribute->name, ['controller' => 'Attributes', 'action' => 'view', $attributeProduct->attribute->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($attributeProduct->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($attributeProduct->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($attributeProduct->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Value') ?></h4>
        <?= $this->Text->autoParagraph(h($attributeProduct->value)); ?>
    </div>
</div>
