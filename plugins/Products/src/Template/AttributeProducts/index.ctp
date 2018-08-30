<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Attribute Product'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Attributes'), ['controller' => 'Attributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Attribute'), ['controller' => 'Attributes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="attributeProducts index large-9 medium-8 columns content">
    <h3><?= __('Attribute Products') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('content_id') ?></th>
                <th><?= $this->Paginator->sort('attribute_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attributeProducts as $attributeProduct): ?>
            <tr>
                <td><?= $this->Number->format($attributeProduct->id) ?></td>
                <td><?= $attributeProduct->has('content') ? $this->Html->link($attributeProduct->content->name, ['controller' => 'Contents', 'action' => 'view', $attributeProduct->content->id]) : '' ?></td>
                <td><?= $attributeProduct->has('attribute') ? $this->Html->link($attributeProduct->attribute->name, ['controller' => 'Attributes', 'action' => 'view', $attributeProduct->attribute->id]) : '' ?></td>
                <td><?= h($attributeProduct->created) ?></td>
                <td><?= h($attributeProduct->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $attributeProduct->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $attributeProduct->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $attributeProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attributeProduct->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
