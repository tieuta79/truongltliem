<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Translate'), ['action' => 'edit', $translate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Translate'), ['action' => 'delete', $translate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $translate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Translates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Translate'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Languages'), ['controller' => 'Languages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Language'), ['controller' => 'Languages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locales'), ['controller' => 'Locales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Locale'), ['controller' => 'Locales', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="translates view large-9 medium-8 columns content">
    <h3><?= h($translate->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Language') ?></th>
            <td><?= $translate->has('language') ? $this->Html->link($translate->language->name, ['controller' => 'Languages', 'action' => 'view', $translate->language->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Locale') ?></th>
            <td><?= $translate->has('locale') ? $this->Html->link($translate->locale->id, ['controller' => 'Locales', 'action' => 'view', $translate->locale->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($translate->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Msgstr') ?></h4>
        <?= $this->Text->autoParagraph(h($translate->msgstr)); ?>
    </div>
</div>
