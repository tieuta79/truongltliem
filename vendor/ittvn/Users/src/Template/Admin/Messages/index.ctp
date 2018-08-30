<?php
$this->assign('title', __d('ittvn', 'Messages'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Messages'), ['controller' => 'Messages', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Message'));
?>
