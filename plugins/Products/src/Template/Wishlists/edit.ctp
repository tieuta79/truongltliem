<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $wishlist->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $wishlist->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Wishlists'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contents'), ['controller' => 'Contents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Content'), ['controller' => 'Contents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wishlists form large-9 medium-8 columns content">
    <?= $this->Form->create($wishlist) ?>
    <fieldset>
        <legend><?= __('Edit Wishlist') ?></legend>
        <?php
            echo $this->Form->input('content_id', ['options' => $contents, 'empty' => true]);
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->input('delete');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
