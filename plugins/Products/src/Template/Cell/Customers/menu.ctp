<div class="col-xs-24 col-md-6">
    <div class="row box_title">
        <div class="col-xs-6 col-md-6">
            <?= $this->Html->image('avatar_default.jpg', ['width' => 50]); ?>
        </div>
        <div class="col-xs-18 col-md-18 box_title_name">
            <p><?= sprintf(__d('ittvn', 'My account of')); ?> </p>
            <h6 class="sb-title"><?= $this->request->session()->read('Auth.Registered.full_name'); ?></h6>
        </div>
    </div>       
    <div class="row box_content">
        <div class="list-group">
            <?php
            if ($this->request->plugin == 'Users' && $this->request->controller == 'Users' && $this->request->action == 'view' && $this->request->role == $this->request->session()->read('Auth.Registered.role.slug')) {
                echo $this->Html->link(__d('ittvn', 'Infomation General'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'view', 'role' => $this->request->session()->read('Auth.Registered.role.slug')], ['class' => 'list-group-item active']);
            } else {
                echo $this->Html->link(__d('ittvn', 'Infomation General'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'view', 'role' => $this->request->session()->read('Auth.Registered.role.slug')], ['class' => 'list-group-item']);
            }

            if ($this->request->plugin == 'Users' && $this->request->controller == 'Users' && $this->request->action == 'edit' && $this->request->role == $this->request->session()->read('Auth.Registered.role.slug')) {
                echo $this->Html->link(__d('ittvn', 'Infomation'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'edit', 'role' => $this->request->session()->read('Auth.Registered.role.slug')], ['class' => 'list-group-item active']);
            } else {
                echo $this->Html->link(__d('ittvn', 'Infomation'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'edit', 'role' => $this->request->session()->read('Auth.Registered.role.slug')], ['class' => 'list-group-item']);
            }

            if ($this->request->plugin == 'Products' && $this->request->controller == 'Addresses' && $this->request->action == 'index') {
                echo $this->Html->link(__d('ittvn', 'Addresses') . ' <span class="badge">' . $count_address . '</span>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'index'], ['escape' => false, 'class' => 'list-group-item active']);
            } else {
                echo $this->Html->link(__d('ittvn', 'Addresses') . ' <span class="badge">' . $count_address . '</span>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'index'], ['escape' => false, 'class' => 'list-group-item']);
            }
            
            if ($this->request->plugin == 'Products' && $this->request->controller == 'Orders' && $this->request->action == 'index') {
                echo $this->Html->link(__d('ittvn', 'My Orders') . ' <span class="badge">' . $count_order . '</span>', ['plugin' => 'Products', 'controller' => 'Orders', 'action' => 'index'], ['escape' => false, 'class' => 'list-group-item active']);
            } else {
                echo $this->Html->link(__d('ittvn', 'My Orders') . ' <span class="badge">' . $count_order . '</span>', ['plugin' => 'Products', 'controller' => 'Orders', 'action' => 'index'], ['escape' => false, 'class' => 'list-group-item']);
            }
            
            if ($this->request->plugin == 'Products' && $this->request->controller == 'Wishlists' && $this->request->action == 'index') {
                echo $this->Html->link(__d('ittvn', 'Wish List') . ' <span class="badge">' . $count_wishlist . '</span>', ['plugin' => 'Products', 'controller' => 'Wishlists', 'action' => 'index'], ['escape' => false, 'class' => 'list-group-item active']);
            } else {
                echo $this->Html->link(__d('ittvn', 'Wish List') . ' <span class="badge">' . $count_wishlist . '</span>', ['plugin' => 'Products', 'controller' => 'Wishlists', 'action' => 'index'], ['escape' => false, 'class' => 'list-group-item']);
            }
            ?>
        </div>
    </div>
</div>