<?php
$this->assign('title', __d('ittvn', 'Messages Users'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Messages Users'), ['controller' => 'MessagesUsers', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All MessagesUser'));
?>
