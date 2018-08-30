<?php

//pr($contents->toArray());
?>
<div class="col-lg-6 pr-2 pl-2 pb-2">
    <h2 class="text-center"><?php echo $category->name; ?> </h2>
    <?php if ($contents->count() >0) : ?>
    <ul class="list-unstyled">
        <?php foreach($contents as $content): ?>
        <li>
            <?php if(!empty($content->image)): ?>
            <?=
            $this->Html->link(
                            $this->Html->image($content->image, ['class' => 'attachment-mgn-slider wp-post-image wp-post-image','width'=>253]), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['escape' => false]
            );
            ?>
            <?php endif; ?>                             
            <div class="head-comm">
                <h5>
                    <?= $this->Html->link($this->Text->truncate($content->name,50,['ellipsis' => '...','exact' => false]), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['title' => $content->name]);?>						
                    <br /><span class="post-date"><i class="fa fa-calendar"></i> <?= $content->created->format('d M'); ?> Năm <?= $content->created->format('Y'); ?></span>
                </h5>
            </div>            
            <p>
                <?= $this->Text->truncate($content->excerpt,100,['ellipsis' => '...','exact' => false]); ?>
                <?= $this->Html->link(__d('ittvn','Xem tiếp'), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class'=>'rmore','title' => $content->name]);?>	
            </p>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>    
</div>