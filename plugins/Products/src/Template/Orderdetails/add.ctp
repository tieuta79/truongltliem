<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Orderdetails'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orderdetails form large-9 medium-8 columns content">
    <?= $this->Form->create($orderdetail) ?>
    <fieldset>
        <legend><?= __('Add Orderdetail') ?></legend>
        <?php
            echo $this->Form->input('content_id', ['options' => $contents, 'empty' => true]);
            echo $this->Form->input('order_id');
            echo $this->Form->input('price');
            echo $this->Form->input('quantity');
            echo $this->Form->input('total');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
