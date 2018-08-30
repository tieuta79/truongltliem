<?php

$this->assign('title', __d('ittvn', 'Cities'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Cities'), ['plugin' => 'Countries', 'controller' => 'Cities', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Cities'));
?>