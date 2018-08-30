<?php

$this->assign('title', __d('ittvn', 'Wards'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Wards'), ['plugin' => 'Countries', 'controller' => 'Wards', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Edit Ward'), $this->request->here);
?>