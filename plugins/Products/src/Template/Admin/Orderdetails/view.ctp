<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Orderdetail'), ['action' => 'edit', $orderdetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Orderdetail'), ['action' => 'delete', $orderdetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderdetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Orderdetails'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Orderdetail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orderdetails view large-9 medium-8 columns content">
    <h3><?= h($orderdetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Content') ?></th>
            <td><?= $orderdetail->has('content') ? $this->Html->link($orderdetail->content->name, ['controller' => 'Contents', 'action' => 'view', $orderdetail->content->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($orderdetail->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Order Id') ?></th>
            <td><?= $this->Number->format($orderdetail->order_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Price') ?></th>
            <td><?= $this->Number->format($orderdetail->price) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($orderdetail->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Total') ?></th>
            <td><?= $this->Number->format($orderdetail->total) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Orders') ?></h4>
        <?php if (!empty($orderdetail->orders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Request') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Receiver') ?></th>
                <th><?= __('Address') ?></th>
                <th><?= __('Phone') ?></th>
                <th><?= __('Fee') ?></th>
                <th><?= __('Payment Id') ?></th>
                <th><?= __('Price') ?></th>
                <th><?= __('Orderdetail Id') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Check') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($orderdetail->orders as $orders): ?>
            <tr>
                <td><?= h($orders->id) ?></td>
                <td><?= h($orders->name) ?></td>
                <td><?= h($orders->request) ?></td>
                <td><?= h($orders->user_id) ?></td>
                <td><?= h($orders->receiver) ?></td>
                <td><?= h($orders->address) ?></td>
                <td><?= h($orders->phone) ?></td>
                <td><?= h($orders->fee) ?></td>
                <td><?= h($orders->payment_id) ?></td>
                <td><?= h($orders->price) ?></td>
                <td><?= h($orders->orderdetail_id) ?></td>
                <td><?= h($orders->status) ?></td>
                <td><?= h($orders->check) ?></td>
                <td><?= h($orders->created) ?></td>
                <td><?= h($orders->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
