<?php
use Ittvn\Utility\User;
?>
<div class="theme-intro responsive">
    <div class="container">
        <?php foreach ($contents as $post): ?>
        
        <div class="col-md-7 theme-image">
            <div class="image-desktop hidden-xs">
                <?= $this->Html->image($post->image, ['width' => 430]); ?>
            </div>
        </div>
        <div class="col-md-5 ali" align ="right">
            <h1 class="text-md-right" style="color: #0000FF"><?php echo "$post->name" ?></h1>
            <div class="desc text-md-right">
                <?php echo "$post->description" ?>
            </div>
            <div class="other-info clearfix">
                <p class="price text-md-right" style="color: red"><?= __d('ittvn', 'Miễn phí'); ?></p>
            </div>
            <div class="t9vheme-action text-md-right">
                <?php if(User::checkLogin()): ?>
                <?= $this->Html->link(__d('ittvn','CHỌN'), ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'website', 'role' => 'customers', 'slug' =>$post->slug], ['class' => 'btn btn-w-m btn-primary']); ?>
                <?php endif; ?>
                <?= $this->Html->link(__d('ittvn','XEM'), [], ['class' => 'btn btn-w-m btn-primary']); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>