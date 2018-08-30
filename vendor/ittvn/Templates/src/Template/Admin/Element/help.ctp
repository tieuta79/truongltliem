<?php

use Ittvn\Utility\Help;

$content = Help::show();
?>
<div class="block-right-help">
    <a href="javascript:void(0)" class="help-toggle" data-open="close" title="<?= __d('ittvn', 'Help'); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
    <div class="help-content" data-scroll="true" data-height="470">
        <div class="row">
            <div class="col-md-12">
                <?= $content; ?>
            </div>
        </div>
    </div>
</div>