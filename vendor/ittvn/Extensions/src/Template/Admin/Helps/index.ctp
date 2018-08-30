<?php
$this->assign('title', __d('ittvn', 'Helps'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Helps'), ['controller' => 'Helps', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Help'));
?>
