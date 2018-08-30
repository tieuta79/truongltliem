<?php
use Cake\Utility\Hash;
$this->assign('title', $content->name);
$this->Html->addCrumb($this->Html->tag('strong',$this->Text->truncate($content->name,70,['ellipsis' => '...','exact' => false])));
?>
<div id="post-599" class="post-599 post type-post status-publish format-standard hentry category-business category-entertainment category-photos category-politics category-review-two category-technology tag-lumia-800 tag-nokia">
	<div class="singlemeta">
		<ul>
			<li><span class="bg-color"> <i class="icon-calendar"></i> <?= $content->created->format('d/m/Y'); ?> </span> </li>
			<?php 
				if(count($content->categories)):
					$cat_name = Hash::extract($content->categories,'{n}.name');					
			?>
			<li><span class="bg-color"><i class="icon-bookmark"></i> <?= implode(', ',$cat_name); ?></span></li>
			<?php endif; ?>
		</ul>
	</div>
	<!--
	<div class="singletitle">
		<h2><?= $content->name; ?></h2>
	</div>
	-->
	<?= $content->description; ?>
	<div class="clear"> </div>
	<?= $this->cell('Contents.Content::related',$categories); ?>
</div>