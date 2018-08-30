<?php if ($medias->count()): ?>
    <div id="Img_carousel" class="slider-pro">
        <div class="sp-slides">
            <?php $thumnail = []; ?>
            <?php foreach ($medias as $k => $media): ?>
                <div class="sp-slide">
                    <?=
                    $this->Html->image('/css/images/blank.gif', [
                        'class' => 'sp-image',
                        'data-src' => $this->Layout->resizeImage($media->url, '1000x667'),
                        'data-small' => $this->Layout->resizeImage($media->url, '500x333'),
                        'data-medium' => $this->Layout->resizeImage($media->url, '1000x667'),
                        'data-large' => $this->Layout->resizeImage($media->url, '2000x1333'),
                        'data-retina' => $this->Layout->resizeImage($media->url, '2000x1333'),
                    ]);
                    ?>
                    <?php $thumnail[] = $this->Html->image($this->Layout->resizeImage($media->url, '1000x667'), ['class' => 'sp-thumbnail']); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="sp-thumbnails">
            <?= implode('', $thumnail); ?>
        </div>
    </div>
<?php endif; ?>