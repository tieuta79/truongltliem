<?php
$this->assign('title', __d('ittvn', 'Redirecturls'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Redirecturls'), ['controller' => 'Redirecturls', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Redirecturl'));
?>
