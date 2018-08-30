<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Booking'), ['action' => 'edit', $booking->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Booking'), ['action' => 'delete', $booking->id], ['confirm' => __('Are you sure you want to delete # {0}?', $booking->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bookings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Booking'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bookings view large-9 medium-8 columns content">
    <h3><?= h($booking->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Content') ?></th>
            <td><?= $booking->has('content') ? $this->Html->link($booking->content->name, ['controller' => 'Contents', 'action' => 'view', $booking->content->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('First Name') ?></th>
            <td><?= h($booking->first_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Last Name') ?></th>
            <td><?= h($booking->last_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($booking->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Phone') ?></th>
            <td><?= h($booking->phone) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($booking->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Adults') ?></th>
            <td><?= $this->Number->format($booking->adults) ?></td>
        </tr>
        <tr>
            <th><?= __('Children') ?></th>
            <td><?= $this->Number->format($booking->children) ?></td>
        </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= $this->Number->format($booking->delete) ?></td>
        </tr>
        <tr>
            <th><?= __('Checkin') ?></th>
            <td><?= h($booking->checkin) ?></td>
        </tr>
        <tr>
            <th><?= __('Checkout') ?></th>
            <td><?= h($booking->checkout) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($booking->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($booking->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $booking->status ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
