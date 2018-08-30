<?php

$this->assign('title', __d('ittvn', 'Attributes'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Attributes'), ['plugin' => 'Products', 'controller' => 'Attributes', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Attributes'));
?>