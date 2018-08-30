<?php

$this->assign('title', __d('ittvn', 'Extra Fields'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Extra Fields'), ['plugin' => 'Metas', 'controller' => 'Metas', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Extra Fields'));
?>