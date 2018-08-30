<?php
use Cake\Core\Configure;
use Ittvn\Utility\System;
$system = new System();
$this->assign('title', $content->name);
$this->Html->addCrumb($this->Html->tag('strong', $content->name));
?>
<?php
$this->start('left');
echo $system->getModule('sidebar');
$this->end();
?>
<?= $this->cell('ItThemes.Theme::school_theme_detail'); ?>