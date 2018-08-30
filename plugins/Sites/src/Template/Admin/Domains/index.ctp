<?php
$this->assign('title', __d('ittvn', 'Domains'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Domains'), ['controller' => 'Domains', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Domain'));
?>
