<?php

use Cake\I18n\Time;
use Cake\Core\Configure;
use Settings\Utility\Setting;

$setting = new Setting();
?>
<div class="header">
                <div class="banner">
                    <?php echo $this->Html->image('banner.jpg', ['alt' => '', 'width' => '100%']); ?>
                    
                </div>
                <div class="menu">
                                        
                    <nav class="navbar navbar-toggleable-md navbar-light bg-red-menu">
                        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand hidden-lg-up" href="#">Menu</a>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <?=
                            $this->cell('Menus.Menus::show', [
                                'menutype' => 1,
                                'options' => [
                                    'attributes' => ['class' => 'navbar-nav'],
                                    'tags' => [
                                        'child' => ['tag' => 'li', 'attribute' => ['class' => 'nav-item']],
                                    ],
                                    'subTags' => [
                                        'parent' => ['tag' => 'ul', 'attribute' => ['class' => 'dropdown-menu']],
                                        'child' => ['tag' => 'li', 'attribute' => ['class' => 'nav-item']]
                                    ],
                                    'hasChild' => ['class' => 'dropdown']
                                ]
                            ]);
                            ?>
                        </div>
                </nav>
                </div>
            </div>            
<!-- END HEADER -->