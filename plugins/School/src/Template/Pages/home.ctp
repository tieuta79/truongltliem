<?php

use Ittvn\Utility\System;

$system = new System();
echo $system->getModule('alert');
?>

<!-- hslidernews-bg -->
<?php //get_template_part('content', 'alert');  ?> 
<?php //get_template_part('content', 'news');  ?> 
<div class="two-cat-cover">
    <ul>    
        <?= $system->getModule('home-page'); ?>   
        <?php //get_template_part('content', 'expertises'); ?>              
        <?php //get_template_part('content', 'project'); ?>               
    </ul>
    <div class="clear"> </div>
</div>		        

<?php //do_shortcode('[tnt_video_list]') ?>        

<div class="two-cat-cover">
    <ul>
        <?php //get_template_part('content', 'team'); ?>                
        <?php //get_template_part('content', 'education'); ?>               
    </ul>
    <div class="clear"> </div>
</div>
