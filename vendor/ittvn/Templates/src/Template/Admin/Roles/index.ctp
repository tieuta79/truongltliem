<?php

$this->assign('title', __d('ittvn', 'Roles'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Roles'), ['plugin' => 'Roles', 'controller' => 'Roles', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Roles'));
?>