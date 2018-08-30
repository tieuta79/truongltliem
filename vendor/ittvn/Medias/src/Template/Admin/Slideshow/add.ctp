<?php

$this->assign('title', __d('ittvn', 'Add slideshow'));
$this->extend('/Admin/Common/form');
$this->Admin->adminScript('slideshow');
$this->Html->addCrumb(__d('ittvn', 'Slideshow'), ['controller' => 'Slideshow', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Add Slideshow'), ['controller' => 'Slideshow', 'action' => 'add']);
?>
