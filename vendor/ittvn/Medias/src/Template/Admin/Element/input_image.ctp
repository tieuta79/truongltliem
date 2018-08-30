<?php

use Cake\Routing\Router; ?>

<div class="text-center it_upload_image">
    <?php if (!empty($label)): ?>
        <div class="col-md-12 text-left">
            <label><?= $label; ?></label>
        </div>
    <?php endif; ?>
    <a class="preview_file" data-toggle="modal" href="<?= Router::url(['plugin' => 'Medias', 'controller' => 'Medias', 'action' => 'popup', 'element_return' => $return_element]); ?>" data-target="#modal_ajax">
        <i class="fa fa-cloud-upload"></i>
    </a>
</div>