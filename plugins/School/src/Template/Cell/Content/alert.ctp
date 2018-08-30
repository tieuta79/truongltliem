<?php
use Settings\Utility\Setting;

$setting = new Setting();
?>
<div class="break-news">
    <h3 class="side-cat"><?= isset($data['title']) ? $data['title'] : ''; ?> </h3>
    <?php if ($contents->count() > 0): ?>
        <ul class="breakcaro">
            <?php foreach ($contents as $content): ?>
                <li>
                    <div class="breakimg">
                        <?php if(!empty($content->image)): ?>
                        <?= $this->Html->image($content->image,['class'=>'attachment-mgn-square wp-post-image wp-post-image','width'=>51,'height'=>55]); ?>
                        <?php else: ?>
                        <?= $this->Html->image($setting->getThemeOption('logo'),['class'=>'attachment-mgn-square wp-post-image wp-post-image','width'=>51,'height'=>55]); ?>
                        <?php endif; ?>
                    </div>
                    <h3>
                        <?=
                        $this->Html->link(
                                $content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id]
                        );
                        ?>
                    </h3>
                    <span class="clock"> <i class="icon-calendar-empty"></i> <?= $content->created->format('d/m/Y'); ?> </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>