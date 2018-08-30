<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Apis', []);
$this->assign('title', __d('ittvn', 'View api'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Apis'), ['controller' => 'Apis', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View api'), $this->request->here);
?>
