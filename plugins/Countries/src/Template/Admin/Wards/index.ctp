<?php

$this->assign('title', __d('ittvn', 'Wards'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Wards'), ['plugin' => 'Countries', 'controller' => 'Wards', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Wards'));
?>