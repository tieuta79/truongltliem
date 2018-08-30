<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ward'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Provinces'), ['controller' => 'Provinces', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Province'), ['controller' => 'Provinces', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wards index large-9 medium-8 columns content">
    <h3><?= __('Wards') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th><?= $this->Paginator->sort('country_id') ?></th>
                <th><?= $this->Paginator->sort('province_id') ?></th>
                <th><?= $this->Paginator->sort('city_id') ?></th>
                <th><?= $this->Paginator->sort('delete') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wards as $ward): ?>
            <tr>
                <td><?= $this->Number->format($ward->id) ?></td>
                <td><?= h($ward->name) ?></td>
                <td><?= h($ward->slug) ?></td>
                <td><?= $ward->has('country') ? $this->Html->link($ward->country->name, ['controller' => 'Countries', 'action' => 'view', $ward->country->id]) : '' ?></td>
                <td><?= $ward->has('province') ? $this->Html->link($ward->province->name, ['controller' => 'Provinces', 'action' => 'view', $ward->province->id]) : '' ?></td>
                <td><?= $ward->has('city') ? $this->Html->link($ward->city->name, ['controller' => 'Cities', 'action' => 'view', $ward->city->id]) : '' ?></td>
                <td><?= h($ward->delete) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ward->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ward->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ward->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ward->id)]) ?>
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
