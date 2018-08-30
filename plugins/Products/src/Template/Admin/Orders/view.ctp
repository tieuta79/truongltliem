<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Order'), ['action' => 'edit', $order->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Order'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orderdetails'), ['controller' => 'Orderdetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Orderdetail'), ['controller' => 'Orderdetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orders view large-9 medium-8 columns content">
    <h3><?= h($order->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($order->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Request') ?></th>
            <td><?= h($order->request) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $order->has('user') ? $this->Html->link($order->user->id, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Receiver') ?></th>
            <td><?= h($order->receiver) ?></td>
        </tr>
        <tr>
            <th><?= __('Address') ?></th>
            <td><?= h($order->address) ?></td>
        </tr>
        <tr>
            <th><?= __('Phone') ?></th>
            <td><?= h($order->phone) ?></td>
        </tr>
        <tr>
            <th><?= __('Payment') ?></th>
            <td><?= $order->has('payment') ? $this->Html->link($order->payment->name, ['controller' => 'Payments', 'action' => 'view', $order->payment->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($order->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Fee') ?></th>
            <td><?= $this->Number->format($order->fee) ?></td>
        </tr>
        <tr>
            <th><?= __('Price') ?></th>
            <td><?= $this->Number->format($order->price) ?></td>
        </tr>
        <tr>
            <th><?= __('Orderdetail Id') ?></th>
            <td><?= $this->Number->format($order->orderdetail_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $this->Number->format($order->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Check') ?></th>
            <td><?= $this->Number->format($order->check) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($order->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($order->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Orderdetails') ?></h4>
        <?php if (!empty($order->orderdetails)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Content Id') ?></th>
                <th><?= __('Order Id') ?></th>
                <th><?= __('Price') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Total') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($order->orderdetails as $orderdetails): ?>
            <tr>
                <td><?= h($orderdetails->id) ?></td>
                <td><?= h($orderdetails->content_id) ?></td>
                <td><?= h($orderdetails->order_id) ?></td>
                <td><?= h($orderdetails->price) ?></td>
                <td><?= h($orderdetails->quantity) ?></td>
                <td><?= h($orderdetails->total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Orderdetails', 'action' => 'view', $orderdetails->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Orderdetails', 'action' => 'edit', $orderdetails->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orderdetails', 'action' => 'delete', $orderdetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderdetails->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
