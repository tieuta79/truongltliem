<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Domains', []);
$this->assign('title', __d('ittvn', 'View domain'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Domains'), ['controller' => 'Domains', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View domain'), $this->request->here);
?>
