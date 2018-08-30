<?php
$this->assign('title', __d('ittvn', 'Translates'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Translates'), ['controller' => 'Translates', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Translate'));
?>
