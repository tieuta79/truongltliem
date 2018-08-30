<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Filters', []);
$this->assign('title', __d('ittvn', 'View filter'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Filters'), ['controller' => 'Filters', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View filter'), $this->request->here);
?>
