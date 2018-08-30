<?php

$this->assign('title', __d('ittvn', 'Add Payment'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Payments'), ['plugin' => 'Products', 'controller' => 'Payments', 'action' => 'index']);

$this->Html->addCrumb(__d('ittvn', 'Add Payment'), ['plugin' => 'Products', 'controller' => 'Payments', 'action' => 'add']);
?>