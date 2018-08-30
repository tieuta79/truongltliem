<?php

$this->assign('title', __d('ittvn', 'Settings'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Settings'), ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Setting'));
?>