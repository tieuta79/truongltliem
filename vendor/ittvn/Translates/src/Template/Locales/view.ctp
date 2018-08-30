<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Locale'), ['action' => 'edit', $locale->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Locale'), ['action' => 'delete', $locale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locale->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Locales'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Locale'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Translates'), ['controller' => 'Translates', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Translate'), ['controller' => 'Translates', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="locales view large-9 medium-8 columns content">
    <h3><?= h($locale->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Domain') ?></th>
            <td><?= h($locale->domain) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($locale->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($locale->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($locale->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Msgid') ?></h4>
        <?= $this->Text->autoParagraph(h($locale->msgid)); ?>
    </div>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($locale->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Translates') ?></h4>
        <?php if (!empty($locale->translates)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Language Id') ?></th>
                <th><?= __('Locale Id') ?></th>
                <th><?= __('Msgstr') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($locale->translates as $translates): ?>
            <tr>
                <td><?= h($translates->id) ?></td>
                <td><?= h($translates->language_id) ?></td>
                <td><?= h($translates->locale_id) ?></td>
                <td><?= h($translates->msgstr) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Translates', 'action' => 'view', $translates->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Translates', 'action' => 'edit', $translates->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Translates', 'action' => 'delete', $translates->id], ['confirm' => __('Are you sure you want to delete # {0}?', $translates->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
