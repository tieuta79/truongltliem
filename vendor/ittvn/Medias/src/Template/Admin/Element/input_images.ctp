<?php

use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
?>
<div class="row">
    <?php if (!empty($label)): ?>
        <div class="col-md-12 text-left">
            <label><?= $label; ?></label>
        </div>
    <?php endif; ?>
    <div class="sortable preview_files gallery_sortable">

    </div>
</div>

<div class="text-center it_upload_image">
    <a class="btn btn-info" data-toggle="modal" href="<?= Router::url(['plugin' => 'Medias', 'controller' => 'Medias', 'action' => 'popup', 'element_return' => $return_element, 'multiple' => 1]); ?>" data-target="#modal_ajax">
        <?= __d('ittvn', 'Select Images'); ?>
    </a>
</div>