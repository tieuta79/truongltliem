<?php

$this->assign('title', __d('ittvn', 'Languages'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Languages'), ['plugin' => 'Extensions', 'controller' => 'Languages', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-flag"></i> ' . __d('ittvn', 'Languages'));
?>