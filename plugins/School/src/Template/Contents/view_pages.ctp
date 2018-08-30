<?php
$this->assign('title', $content->name);
$this->Html->addCrumb($this->Html->tag('strong',$content->name));
?>
<div class="post-599 post type-post status-publish format-standard hentry category-business category-entertainment category-photos category-politics category-review-two category-technology tag-lumia-800 tag-nokia">
    <?= $content->description; ?>
    <div class="clear"> </div>
</div> 