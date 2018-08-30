<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Redirecturl'), ['action' => 'edit', $redirecturl->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Redirecturl'), ['action' => 'delete', $redirecturl->id], ['confirm' => __('Are you sure you want to delete # {0}?', $redirecturl->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Redirecturls'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Redirecturl'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="redirecturls view large-9 medium-8 columns content">
    <h3><?= h($redirecturl->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Request') ?></th>
            <td><?= h($redirecturl->request) ?></td>
        </tr>
        <tr>
            <th><?= __('Target') ?></th>
            <td><?= h($redirecturl->target) ?></td>
        </tr>
        <tr>
            <th><?= __('Options') ?></th>
            <td><?= h($redirecturl->options) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($redirecturl->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($redirecturl->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($redirecturl->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= $redirecturl->delete ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
