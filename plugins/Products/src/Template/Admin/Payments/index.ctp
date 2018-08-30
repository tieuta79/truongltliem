<?php
$this->assign('title', __d('ittvn', 'Payments'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Payments'), ['plugin'=>'Products','controller' => 'Payments', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Payment'));
?>