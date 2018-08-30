<?php
$this->assign('title', __d('ittvn', 'Locales'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Locales'), ['controller' => 'Locales', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Locale'));
?>
