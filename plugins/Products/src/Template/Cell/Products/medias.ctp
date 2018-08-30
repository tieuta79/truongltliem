<div id="detail-left-column" class="hidden-xs left-coloum col-sm-2 col-sm-2 fadeInRight animated" data-animate="fadeInRight">
    <div id="gallery_main" class="product-image-thumb thumbs full_width ">
        <?php if ($medias->count()): ?>
            <ul class="slide-product-image">													
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
</div>