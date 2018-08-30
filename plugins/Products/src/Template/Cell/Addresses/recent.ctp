<div class="row">
    <div class="col-md-24">
        <h5>
            <span><?= __d('ittvn', 'Address book'); ?></span>
            <?= $this->Html->link(__d('ittvn', 'View all') . ' <i class="fa fa-angle-right" aria-hidden="true"></i>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'index'], ['escape' => false, 'class' => 'edit_account pull-right']); ?>
        </h5>
        <div class="row">
            <?php foreach ($addresses as $address): ?>
                <div class="col-md-12">
                    <div class="info_user">
                        <p>
                            <strong><?= $address->name; ?> </strong>
                            <?php if ($address->default == 1): ?>
                                <span class="pull-right text-success"><?= __d('ittvn', 'Default'); ?></span>
                            <?php endif; ?>
                        </p>
                        <p>
                            <span><?= sprintf(__d('ittvn', 'Address')); ?>: </span>
                            <span><?= sprintf(__d('ittvn', '%s, %s, %s, %s'), $address->address, $address->ward->name, $address->city->name, $address->province->name); ?></span>
                        </p>
                        <p>
                            <span><?= sprintf(__d('ittvn', 'Phone')); ?>: </span>
                            <span><?= $this->request->session()->read('Auth.Registered.phone'); ?></span>
                        </p>
                        <?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'edit', $address->id], ['class' => 'btn btn-2', 'escape' => false]) ?>
                        <?php if ($address->default != 1): ?>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'delete', $address->id], ['class' => 'btn btn-2', 'escape' => false]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>  