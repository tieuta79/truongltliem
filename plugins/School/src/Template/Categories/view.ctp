<?php
$this->Html->addCrumb($category->name, $this->request->here);
?>
<div id="category" class="post-599 post type-post status-publish format-standard hentry category-business category-entertainment category-photos category-politics category-review-two category-technology tag-lumia-800 tag-nokia">

	<?php if ($contents->count() >0) : ?>
	<div class="top-inner">
		<div class="top-first">
			<ul>
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
						<h3>
							<?=
							$this->Html->link(
									$this->Text->truncate($content->name,50,['ellipsis' => '...','exact' => false]), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['title' => $content->name]
							);
							?>						
							<br /><span class="post-date"><i class="icon-calendar"></i> <?= $content->created->format('d M'); ?> Năm <?= $content->created->format('Y'); ?></span>
						</h3>
					</div>
					<div class="clearfix"></div>
					<p><?= $this->Text->truncate($content->excerpt,100,['ellipsis' => '...','exact' => false]); ?><br />
						<?=
						$this->Html->link(
								__d('ittvn','Xem tiếp'), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class'=>'rmore','title' => $content->name]
						);
						?>	
					</p>
				</li>
				<?php endforeach; ?>                    
			</ul>

		</div> <!-- top-first -->     
	</div>
	<div class="clear"> </div>
	<?php endif ?>            
</div>   