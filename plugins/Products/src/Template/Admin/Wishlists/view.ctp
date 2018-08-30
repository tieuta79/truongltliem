<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Wishlists', []);
$this->assign('title', __d('ittvn', 'View wishlist'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Wishlists'), ['controller' => 'Wishlists', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View wishlist'), $this->request->here);
?>
