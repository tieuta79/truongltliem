<?php

$this->assign('title', __d('ittvn', 'Attributes'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Attributes'), ['plugin' => 'Products', 'controller' => 'Attributes', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Add Attribute'), ['plugin' => 'Products', 'controller' => 'Attributes', 'action' => 'add']);
?>