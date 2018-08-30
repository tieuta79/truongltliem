<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Logs', []);
$this->assign('title', __d('ittvn', 'View log'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Logs'), ['controller' => 'Logs', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View log'), $this->request->here);
?>
