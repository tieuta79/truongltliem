<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Locales', []);
$this->assign('title', __d('ittvn', 'View locale'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Locales'), ['controller' => 'Locales', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View locale'), $this->request->here);
?>
