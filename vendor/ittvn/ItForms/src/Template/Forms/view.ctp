<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Form'), ['action' => 'edit', $form->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Form'), ['action' => 'delete', $form->id], ['confirm' => __('Are you sure you want to delete # {0}?', $form->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Forms'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Form'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Fields'), ['controller' => 'Fields', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Field'), ['controller' => 'Fields', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="forms view large-9 medium-8 columns content">
    <h3><?= h($form->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($form->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($form->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($form->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($form->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($form->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Menu') ?></th>
            <td><?= $form->menu ? __('Yes') : __('No'); ?></td>
         </tr>
        <tr>
            <th><?= __('List') ?></th>
            <td><?= $form->list ? __('Yes') : __('No'); ?></td>
         </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= $form->delete ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="row">
        <h4><?= __('Before Submit') ?></h4>
        <?= $this->Text->autoParagraph(h($form->before_submit)); ?>
    </div>
    <div class="row">
        <h4><?= __('After Submit') ?></h4>
        <?= $this->Text->autoParagraph(h($form->after_submit)); ?>
    </div>
    <div class="row">
        <h4><?= __('Js') ?></h4>
        <?= $this->Text->autoParagraph(h($form->js)); ?>
    </div>
    <div class="row">
        <h4><?= __('Css') ?></h4>
        <?= $this->Text->autoParagraph(h($form->css)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Fields') ?></h4>
        <?php if (!empty($form->fields)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Slug') ?></th>
                <th><?= __('Value') ?></th>
                <th><?= __('Type') ?></th>
                <th><?= __('Options') ?></th>
                <th><?= __('Attributes') ?></th>
                <th><?= __('Form Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($form->fields as $fields): ?>
            <tr>
                <td><?= h($fields->id) ?></td>
                <td><?= h($fields->name) ?></td>
                <td><?= h($fields->slug) ?></td>
                <td><?= h($fields->value) ?></td>
                <td><?= h($fields->type) ?></td>
                <td><?= h($fields->options) ?></td>
                <td><?= h($fields->attributes) ?></td>
                <td><?= h($fields->form_id) ?></td>
                <td><?= h($fields->created) ?></td>
                <td><?= h($fields->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Fields', 'action' => 'view', $fields->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Fields', 'action' => 'edit', $fields->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Fields', 'action' => 'delete', $fields->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fields->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
