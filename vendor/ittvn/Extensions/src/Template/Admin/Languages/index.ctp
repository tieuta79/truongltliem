<?php
$this->assign('title', __d('ittvn', 'Languages'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Languages'), ['controller' => 'Languages', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Language'));
?>
