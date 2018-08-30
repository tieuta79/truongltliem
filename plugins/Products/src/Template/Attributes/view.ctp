<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Attribute'), ['action' => 'edit', $attribute->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Attribute'), ['action' => 'delete', $attribute->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attribute->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Attributes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Attribute'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Attribute Products'), ['controller' => 'AttributeProducts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Attribute Product'), ['controller' => 'AttributeProducts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="attributes view large-9 medium-8 columns content">
    <h3><?= h($attribute->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($attribute->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($attribute->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($attribute->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($attribute->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($attribute->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $attribute->status ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="row">
        <h4><?= __('Options') ?></h4>
        <?= $this->Text->autoParagraph(h($attribute->options)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Attribute Products') ?></h4>
        <?php if (!empty($attribute->attribute_products)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Content Id') ?></th>
                <th><?= __('Attribute Id') ?></th>
                <th><?= __('Value') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($attribute->attribute_products as $attributeProducts): ?>
            <tr>
                <td><?= h($attributeProducts->id) ?></td>
                <td><?= h($attributeProducts->content_id) ?></td>
                <td><?= h($attributeProducts->attribute_id) ?></td>
                <td><?= h($attributeProducts->value) ?></td>
                <td><?= h($attributeProducts->created) ?></td>
                <td><?= h($attributeProducts->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AttributeProducts', 'action' => 'view', $attributeProducts->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'AttributeProducts', 'action' => 'edit', $attributeProducts->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AttributeProducts', 'action' => 'delete', $attributeProducts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attributeProducts->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
