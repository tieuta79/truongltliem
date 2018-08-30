<?php
$this->assign('title', __d('ittvn', 'Wishlists'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Wishlists'), ['controller' => 'Wishlists', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Wishlist'));
?>
