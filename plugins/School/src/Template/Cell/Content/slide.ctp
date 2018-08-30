<div id="hslidernews-bg">
    <div id="ei-slider" class="ei-slider">
		<?php if ($contents->count() > 0): ?>
        <ul class="ei-slider-large">
			<?php $data = []; ?>
			<?php foreach ($contents as $content): ?>
				<?php
					$data[] = $this->Html->tag(
						'li',
						$this->Html->link(
                            $content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id]
                        ).$this->Html->image($content->image, ['width' => 60, 'height' => 60, 'class' => 'attachment-mgn-eislidernav wp-post-image wp-post-image'])
					);
				?>
            <li>
				<?=
				$this->Html->link(
						$this->Html->image($content->image, ['width' => 400, 'height' => 300, 'class' => 'attachment-mgn-eislider']), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id, 'escape'=>false]
				);
				?>
                <div class="ei-title">
                    <h2>
                        <?=
                        $this->Html->link(
                                $content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id]
                        );
                        ?>
					</h2>
                    <h3><?= $this->Text->truncate($content->excerpt,100,['ellipsis' => '...','exact' => false]); ?><br/>
						<?=
						$this->Html->link(
								__d('ittvn','Xem tiếp'), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class'=>'rmore','title' => $content->name]
						);
						?>
					</h3>
                </div>
                <!-- ei-title -->
            </li>
			<?php endforeach; ?>
        </ul>
        <!-- ei-slider-large -->
		<?php endif; ?>


        <ul class="ei-slider-thumbs">
            <li class="ei-slider-element">Current</li>
			<?php echo implode('',$data); ?>
        </ul>
        <!-- ei-slider-thumbs -->
    </div>
    <!-- ei-slider -->

</div>