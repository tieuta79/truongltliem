<?php
use Ittvn\Utility\User;
?>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <?php foreach ($contents as $post): ?>
            <div class="team-members">
                <?= $this->Html->image($post->image, ['width' => 250, 'url' => ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => $post->meta_type->slug, 'slug' => $post->slug]]); ?>
            </div>
            <h5 class="text-xs-center text-md-center">
                <?= $this->Html->link($post->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => $post->meta_type->slug, 'slug' => $post->slug]); ?>
                </h5>
            <p class="text-md-center"><?= __d('ittvn', 'Ngày kết nối: ')?><?php echo "$post->modified"; ?></p>
            <div class="row  m-t-sm">
                <div class="col-sm-6 text-md-left">
                    <?php if(User::checkLogin()): ?>
                    <?= $this->Html->link('CHỌN', ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'website', 'role' => 'customers', 'slug' => $post->slug], ['class' => 'btn btn-w-m btn-primary']); ?>
                    <?php endif; ?>
                </div>
                <div class="col-sm-6 text-md-right">
                    <div class="font-bold text-md-right" style="color: red"><?= __d('ittvn', 'FREE'); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>