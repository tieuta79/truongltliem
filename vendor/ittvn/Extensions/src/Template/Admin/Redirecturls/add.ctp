<?php
$this->assign('title', __d('ittvn', 'Add redirecturl'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Redirecturls'), ['controller' => 'Redirecturls', 'action' => 'index']);
    
$this->Html->addCrumb(__d('ittvn','Add Redirecturl'), ['controller' => 'Redirecturls', 'action' => 'add']);
?>
