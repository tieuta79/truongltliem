<?php

$this->assign('title', __d('ittvn', 'Provinces'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Provinces'), ['plugin' => 'Countries', 'controller' => 'Provinces', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Edit Province'), $this->request->here);
?>