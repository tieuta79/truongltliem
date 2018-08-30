<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Slideshow', []);
$this->assign('title', __d('ittvn', 'View slideshow'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Slideshow'), ['controller' => 'Slideshow', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View slideshow'), $this->request->here);
?>
