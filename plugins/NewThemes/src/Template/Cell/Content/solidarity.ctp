
<div class="card card-outline-info mb-2">
    <div class="card-header bg-light-blue text-center bg-card-title">
        » <?= isset($data['title']) ? $data['title'] : ''; ?> «
    </div>
    <div class="card-block">
        <ul class="list-unstyled text-center">
            <?php foreach ($contents as $post): ?>
                <li>
                    <?php if(!empty($post->image)): ?>
                    <a href="<?= $post->Link_href_meta; ?>">
                        <?= $this->Html->image($post->image, ['width' => 200]); ?>
                    </a>
                    <?php else: ?>
                        <?= $this->Html->image($setting->getThemeOption('img_default'), ['width' => 60]); ?>
                    <?php endif; ?>                
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>