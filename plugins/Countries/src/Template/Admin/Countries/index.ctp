<?php

$this->assign('title', __d('ittvn', 'Countries'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Countries'), ['plugin' => 'Countries', 'controller' => 'Countries', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Countries'));
?>