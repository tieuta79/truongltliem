<?php
$this->assign('title', __d('ittvn', 'Logs'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Logs'), ['controller' => 'Logs', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Log'));
?>
