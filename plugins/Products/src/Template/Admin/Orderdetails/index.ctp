<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Orderdetail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orderdetails index large-9 medium-8 columns content">
    <h3><?= __('Orderdetails') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('content_id') ?></th>
                <th><?= $this->Paginator->sort('order_id') ?></th>
                <th><?= $this->Paginator->sort('price') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('total') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderdetails as $orderdetail): ?>
            <tr>
                <td><?= $this->Number->format($orderdetail->id) ?></td>
                <td><?= $orderdetail->has('content') ? $this->Html->link($orderdetail->content->name, ['controller' => 'Contents', 'action' => 'view', $orderdetail->content->id]) : '' ?></td>
                <td><?= $this->Number->format($orderdetail->order_id) ?></td>
                <td><?= $this->Number->format($orderdetail->price) ?></td>
                <td><?= $this->Number->format($orderdetail->quantity) ?></td>
                <td><?= $this->Number->format($orderdetail->total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $orderdetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderdetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderdetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderdetail->id)]) ?>
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
