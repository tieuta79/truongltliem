<?php
$this->assign('title', $content->name);
$this->Html->addCrumb($this->Html->tag('strong', $content->name));
//$this->Content->set($content);
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->Content->getByDescription(); ?>
    </div>
</div>