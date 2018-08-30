	<div class="two-box clearfix" style="padding-top: 20px;">
		<h2 class="top-cat">
			<a href="" title="Tin liên quan"><i class="icon-th-list"></i> <?= __d('ittvn','Tin liên quan'); ?></a>	                
		</h2>                
		<div class="right-line"></div>
	</div>   			
	<?php if (isset($contents) && count($contents) > 0): ?>
		<div class="related">
			<div class="top-rest">
				<ul>						
					<?php foreach ($contents as $content): ?>
					<li>
						<?php if(!empty($content->image)): ?>
						<?=
						$this->Html->link(
								$this->Html->image($content->image, ['class' => 'attachment-55x55 wp-post-image','width'=>50,'height'=>50]), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['escape' => false]
						);
						?>
						<?php endif; ?>
						<h3>
							<?=
							$this->Html->link(
									$content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['title' => $content->name]
							);
							?>
						</h3>
						<span class="clock"> <i class="icon-calendar-empty"></i> <?= $content->created->format('d/m/Y'); ?></span>
					</li>                                 
					<?php endforeach; ?>
				</ul>
			</div>                
		</div>       
	<?php endif; ?>