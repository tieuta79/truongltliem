<?php
$this->assign('title', __d('ittvn', 'Sites'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Sites'), ['controller' => 'Sites', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Site'));
?>
