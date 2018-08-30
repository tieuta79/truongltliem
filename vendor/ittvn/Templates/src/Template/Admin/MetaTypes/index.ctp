<?php

$this->assign('title', __d('ittvn', 'Content types'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Content types'), ['plugin' => 'Metas', 'controller' => 'MetaTypes', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Content types'));
?>