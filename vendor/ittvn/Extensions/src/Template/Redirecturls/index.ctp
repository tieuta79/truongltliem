<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Redirecturl'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="redirecturls index large-9 medium-8 columns content">
    <h3><?= __('Redirecturls') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('request') ?></th>
                <th><?= $this->Paginator->sort('target') ?></th>
                <th><?= $this->Paginator->sort('options') ?></th>
                <th><?= $this->Paginator->sort('delete') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($redirecturls as $redirecturl): ?>
            <tr>
                <td><?= $this->Number->format($redirecturl->id) ?></td>
                <td><?= h($redirecturl->request) ?></td>
                <td><?= h($redirecturl->target) ?></td>
                <td><?= h($redirecturl->options) ?></td>
                <td><?= h($redirecturl->delete) ?></td>
                <td><?= h($redirecturl->created) ?></td>
                <td><?= h($redirecturl->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $redirecturl->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $redirecturl->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $redirecturl->id], ['confirm' => __('Are you sure you want to delete # {0}?', $redirecturl->id)]) ?>
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
