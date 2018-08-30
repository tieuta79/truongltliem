<?php
$this->assign('title', __d('ittvn', 'Forms'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Forms'), ['controller' => 'Forms', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Form'));
?>
