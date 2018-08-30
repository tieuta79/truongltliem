<?php

use Ittvn\Utility\System;

$system = new System();
$modules = $system->modules();

if (isset($modules[$module])):
    echo $this->Form->create('Module');
    $method = explode('::',$module);
    echo $this->cell($module, ['params'=>$modules[$module]['params']])->render($method[1].'-form');
    ?>
    <div class="form-group cell_button">                                            
        <div class="col-sm-12">
            <?= $this->Form->button('<i class="fa fa-save"></i> ' . __d('ittvn', 'Save'), ['type' => 'button', 'class' => 'ladda-button btn btn-sm btn-primary', 'data-button'=>'loading','data-style'=>'expand-right']); ?>
        </div>
    </div>
    <?php
    echo $this->Form->end();
endif;
?>