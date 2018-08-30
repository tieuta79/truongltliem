<div id="gallery_main_mobile" class="visible-xs product-image-thumb thumbs mobile_full_width ">
    <?php if ($medias->count()): ?>
        <ul style="opacity: 0; display: block;" class="slide-product-image owl-carousel owl-theme">
            <?php foreach ($medias as $k => $media): ?>
                <li class="image">
                    <?=
                    $this->Html->link(
                            $this->Html->image($this->Layout->resizeImage($media->url,'100x100')), $media->url, ['escape' => false, 'class' => 'cloud-zoom-gallery ' . ($k == 0 ? 'active' : '')]
                    );
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>