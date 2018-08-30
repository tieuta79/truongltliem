<?php
$this->assign('title', __d('ittvn', 'Filters'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Filters'), ['controller' => 'Filters', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Filter'));
?>
