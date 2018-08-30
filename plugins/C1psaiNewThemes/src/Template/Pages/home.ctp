<?php 
use Cake\Core\Configure;
use Ittvn\Utility\System;
$system = new System();
?>
<div class="col-lg-6 pr-2 pl-2 pb-2">
    <div class="home_slider">
        <h4 class="text-center">
            Hình ảnh về trường Tiểu Học Phương Sài
        </h4>
        <?php echo $system->getModule('home-page');?>        
    </div>
    
    <h6 class="text-center">Video - Buổi biểu diễn văn nghệ của trường TH Vĩnh Nguyên 2</h6>
    <div class="responsive-video">
        <iframe  src="http://www.youtube.com/embed/SPUz5ZxcJlY" ></iframe>
    </div>
</div>