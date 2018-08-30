<?php
$this->assign('title', __d('ittvn', 'Apis'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Apis'), ['controller' => 'Apis', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Api'));
?>
