<?php        
$this->assign('title', __d('ittvn', 'Add help'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Helps'), ['controller' => 'Helps', 'action' => 'index']);
    
$this->Html->addCrumb(__d('ittvn','Add Help'), ['controller' => 'Helps', 'action' => 'add']);
?>
