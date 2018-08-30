<?php
    $this->assign('title', $content->name);
    $this->Html->addCrumb($this->Html->tag('strong', $content->name));
?>
<div class="col-lg-6 pr-2 pl-2 pb-2">
    <h4><?= $content->name; ?></h4>
    <div><?= $content->description; ?> </div>
    
    <?= $this->cell('Contents.Content::related',$categories); ?>
</div>