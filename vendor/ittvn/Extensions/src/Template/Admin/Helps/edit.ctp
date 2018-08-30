<?php        
$this->assign('title', __d('ittvn', 'Edit help'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Helps'), ['controller' => 'Helps', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Help'), $this->request->here);
?>
