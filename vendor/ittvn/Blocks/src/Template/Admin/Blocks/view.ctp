<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Blocks', []);
$this->assign('title', __d('ittvn', 'View block'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Blocks'), ['controller' => 'Blocks', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View block'), $this->request->here);
?>
