<?php

$this->assign('title', __d('ittvn', 'Edit Language'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Languages'), ['plugin' => 'Extensions', 'controller' => 'Languages', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Edit Language'), $this->request->here);
?>