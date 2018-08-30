<?php

use Settings\Utility\Setting;

$setting = new Setting();
?>


<div id="top">            
    <div class="top-content">	                                
        <!-- Logo and Banner -->
        <div class="logo"> 
            <?= $this->Html->link($this->Html->image($setting->getThemeOption('logo')), '/', ['title' => $setting->getOption('Sites.title'),'escape'=>false]); ?>                                      
        </div> 
        <!-- logo -->
        <div class="text_banner">
            <?= $setting->getThemeOption('text_banner'); ?>
        </div>  
        <div class="slide_banner">
		<?php 
			if(empty($setting->getThemeOption('choose-banner'))):
				echo $this->Html->image($setting->getThemeOption('img-banner'),['style'=>'width:300px']);
			else: 
			
			endif;
		?>
        </div>                
    </div> 

    <!-- top-content -->
    <div class="clear"> </div>	
    <!-- Primary Menu -->
    <?=
    $this->cell('Menus.Menus::show', [
        'menutype' => 1,
        'options' => [
            'attributes' => ['id' => 'primary-menu', 'class' => 'sf-menu'],
            'container' => [
                'tag' => 'div',
                'attribute' => ['class' => 'mainmenu']
            ],
            'hasChild' => ['class' => 'menu-item-has-children']
        ]
    ]);
    ?>
    <?php // $this->cell('Menus.Menus::show', [1])->render('main'); ?>
    <input type="hidden" value="<?php //echo $theme_options['text_menu_mobile']    ?>" class="text_select_main_menu"/>
    <div class="clear"> </div>
</div> 
<!-- top --> 