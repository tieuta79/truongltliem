<?php
$this->assign('title', __d('ittvn', 'Slideshow'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Slideshow'), ['controller' => 'Slideshow', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Slideshow'));
?>
