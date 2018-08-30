<?php
$this->assign('title', __d('ittvn', 'Fields'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Fields'), ['controller' => 'Fields', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Field'));
?>
