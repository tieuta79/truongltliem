<?php
$this->assign('title', __d('ittvn', 'Blocks'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Blocks'), ['controller' => 'Blocks', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Block'));
?>
