<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Translates', []);
$this->assign('title', __d('ittvn', 'View translate'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Translates'), ['controller' => 'Translates', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View translate'), $this->request->here);
?>
