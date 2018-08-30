<?php
$mine_image = ['image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png'];
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title">
        View Image <?= $media->name; ?> <br />
        <?php if (in_array($media->type, $mine_image)): ?>
        <img src="<?= $media->url; ?>" class="img-responsive" alt="image" width="200" style="margin: 0 auto;"/>
        <?php else: ?>
            <i class="fa fa-laptop modal-icon"></i>
        <?php endif; ?>
    </h4>
</div>
<div class="modal-body">
    <p><strong>Name: </strong><?= $media->name; ?></p>
    <!--<p><strong>Description: </strong><?= $media->description; ?></p>-->
    <p><strong>Url: </strong> <?= $this->Html->link($this->Url->build($media->url,true),$media->url); ?></p>
    <p><strong>Type: </strong><?= $media->type; ?></p>
    <p><strong>Size: </strong><?= round(($media->size / 1048576), 2); ?></p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
</div>