<?php

$this->Admin->adminScript('form');
if ($this->fetch('default-form')):
    echo $this->fetch('default-form');
else:
    echo $this->cell('Templates.Forms::form',['data'=>$this->viewVars])->render('relation1');
endif;
?> 