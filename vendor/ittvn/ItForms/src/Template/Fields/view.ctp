<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Field'), ['action' => 'edit', $field->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Field'), ['action' => 'delete', $field->id], ['confirm' => __('Are you sure you want to delete # {0}?', $field->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Fields'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Field'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Forms'), ['controller' => 'Forms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Form'), ['controller' => 'Forms', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Field Metas'), ['controller' => 'FieldMetas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Field Meta'), ['controller' => 'FieldMetas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fields view large-9 medium-8 columns content">
    <h3><?= h($field->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($field->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($field->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Value') ?></th>
            <td><?= h($field->value) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($field->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Form') ?></th>
            <td><?= $field->has('form') ? $this->Html->link($field->form->name, ['controller' => 'Forms', 'action' => 'view', $field->form->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($field->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($field->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($field->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Options') ?></h4>
        <?= $this->Text->autoParagraph(h($field->options)); ?>
    </div>
    <div class="row">
        <h4><?= __('Attributes') ?></h4>
        <?= $this->Text->autoParagraph(h($field->attributes)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Field Metas') ?></h4>
        <?php if (!empty($field->field_metas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Key') ?></th>
                <th><?= __('Value') ?></th>
                <th><?= __('Field Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($field->field_metas as $fieldMetas): ?>
            <tr>
                <td><?= h($fieldMetas->id) ?></td>
                <td><?= h($fieldMetas->key) ?></td>
                <td><?= h($fieldMetas->value) ?></td>
                <td><?= h($fieldMetas->field_id) ?></td>
                <td><?= h($fieldMetas->created) ?></td>
                <td><?= h($fieldMetas->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FieldMetas', 'action' => 'view', $fieldMetas->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'FieldMetas', 'action' => 'edit', $fieldMetas->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FieldMetas', 'action' => 'delete', $fieldMetas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fieldMetas->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
