<?php
    $this->assign('title', $content->name);
    $this->Html->addCrumb($this->Html->tag('strong', $content->name));
?>
<div class="col-lg-6 pr-2 pl-2 pb-2">
    <div class="card card-outline-info mb-2">
    <div class="card-header bg-light-blue text-center bg-card-title">
        » <?= isset($content['title']) ? $data['title'] : ''; ?> «
    </div>
    <?= $content->description; ?> 
</div>