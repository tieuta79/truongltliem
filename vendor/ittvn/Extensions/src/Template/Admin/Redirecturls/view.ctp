<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Redirecturls', []);
$this->assign('title', __d('ittvn', 'View redirecturl'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Redirecturls'), ['controller' => 'Redirecturls', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View redirecturl'), $this->request->here);
?>
