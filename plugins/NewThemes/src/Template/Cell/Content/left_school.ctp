<?php
use Settings\Utility\Setting;
$setting = new Setting();
?>
<div class="card card-outline-info mb-2">
    <div class="card-header bg-light-blue text-center bg-card-title">
        » <?= isset($data['title']) ? $data['title'] : ''; ?> «
    </div>
    <div class="card-block">
        <?php if ($contents->count() > 0): ?>
        <ul class="list-unstyled">
            <?php foreach ($contents as $post): ?>
            <li>
                <div class="media">
                    <?php if(!empty($post->image)): ?>
                        <?= $this->Html->image($post->image, ['width' => 60]); ?>
                    <?php else: ?>
                        <?= $this->Html->image($setting->getThemeOption('img_default'), ['width' => 60]); ?>
                    <?php endif; ?>
                    <div class="media-body pl-2">
                        <h6 class="text-danger"><?= $this->Html->link($post->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $post->slug]); ?></h6>                        
                    </div>
                </div>     
            </li>
            <?php endforeach;?>
        </ul>
        <?php endif; ?>

    </div>
</div>
