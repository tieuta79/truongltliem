<?php

$this->assign('title', __d('ittvn', 'Provinces'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Provinces'), ['plugin' => 'Countries', 'controller' => 'Provinces', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Provinces'));
?>