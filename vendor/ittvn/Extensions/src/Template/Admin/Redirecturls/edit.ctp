<?php
$this->assign('title', __d('ittvn', 'Edit redirecturl'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Redirecturls'), ['controller' => 'Redirecturls', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Redirecturl'), $this->request->here);
?>
