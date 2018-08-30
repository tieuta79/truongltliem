<?php

use Cake\Core\Configure;
?>
<div class="panel-group smart-accordion-default" id="accordion-slideshow">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion-slideshow" href="#collapseGeneral"> 
                    <i class="fa fa-lg fa-angle-down pull-right"></i> 
                    <i class="fa fa-lg fa-angle-up pull-right"></i> 
                    <strong><?= __d('ittvn', 'General Settings'); ?></strong>
                </a>
            </h4>
        </div>
        <div id="collapseGeneral" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php
                echo $this->Form->input('config.general.autoStart', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Auto start'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['autoStart']) ? $slideshow->config['general']['autoStart'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If true, slideshow will automatically start after loading the page.') . '</i>',
                    ]
                ]);
                echo $this->Form->input('config.general.hover', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Stop hover'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['hover']) ? $slideshow->config['general']['hover'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If ture, SlideShow will pause when you move the mouse pointer over the LayerSlider container.') . '</i>',
                    ]
                ]);

                echo $this->Form->input('config.general.randomSlideshow', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Random Slideshow'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['randomSlideshow']) ? $slideshow->config['general']['randomSlideshow'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If true, LayerSlider will change to a random layer instead of changing to the next / prev layer. Note that \'loops\' feature won\'t work with randomSlideshow!') . '</i>',
                    ]
                ]);

                echo $this->Form->input('config.general.imgPreload', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Image Preload'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['imgPreload']) ? $slideshow->config['general']['imgPreload'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'Image preload. Preloads all images and background-images of the next layer.') . '</i>',
                    ]
                ]);

                echo $this->Form->input('config.general.navPrevNext', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Nav Prev / Next'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['navPrevNext']) ? $slideshow->config['general']['navPrevNext'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If false, Prev and Next buttons will be invisible.') . '</i>',
                    ]
                ]);

                echo $this->Form->input('config.general.navStartStop', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Nav Start / Stop'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['navStartStop']) ? $slideshow->config['general']['navStartStop'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If false, Start and Stop buttons will be invisible.') . '</i>',
                    ]
                ]);

                echo $this->Form->input('config.general.navButtons', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Nav Buttons'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['navButtons']) ? $slideshow->config['general']['navButtons'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If false, slide buttons will be invisible.') . '</i>',
                    ]
                ]);

                echo $this->Form->input('config.general.thumbnailNavigation', [
                    'type' => 'select',
                    'label' => __d('ittvn', 'Thumbnail Navigation'),
                    'class' => 'form-control',
                    'style' => 'width: 100%',
                    'options' => [
                        'hover' => __d('ittvn', 'Hover'),
                        'always' => __d('ittvn', 'Always'),
                        'disabled' => __d('ittvn', 'Disabled')
                    ],
                    'value' => isset($slideshow->config['general']['thumbnailNavigation']) ? $slideshow->config['general']['thumbnailNavigation'] : '',
                    'default' => 'hover',
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form {{required}}" style="padding-bottom: 20px;">{{content}}</div>',
                        'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select> <i class="helptext col-md-12">' . __d('ittvn', 'Thumbnail navigation mode. Can be \'disabled\', \'hover\', \'always\'. Note, that \'hover\' setting needs navButtons true!') . '</i>',
                    ]
                ]);
                ?>
                <div class="row">
                    <br />
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.general.tnWidth', [
                            'type' => 'number',
                            'label' => __d('ittvn', 'Thumbnail width'),
                            'class' => 'form-control text-center',
                            'value' => isset($slideshow->config['general']['tnWidth']) ? $slideshow->config['general']['tnWidth'] : '',
                            'default' => 1,
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                                'input' => '<div class="input-group"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon">px</span></div> <i class="helptext col-md-12">' . __d('ittvn', 'Width of the thumbnails (in pixels).') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.general.tnHeight', [
                            'type' => 'number',
                            'label' => __d('ittvn', 'Thumbnail height'),
                            'class' => 'form-control text-center',
                            'value' => isset($slideshow->config['general']['tnHeight']) ? $slideshow->config['general']['tnHeight'] : '',
                            'default' => 1,
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                                'input' => '<div class="input-group"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon">px</span></div> <i class="helptext col-md-12">' . __d('ittvn', 'Height of the thumbnails (in pixels).') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <?php
                echo $this->Form->input('config.general.hoverPrevNext', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Hover Prev/Next'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['hoverPrevNext']) ? $slideshow->config['general']['hoverPrevNext'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If false, slide buttons will be invisible.') . '</i>',
                    ]
                ]);
                echo $this->Form->input('config.general.hoverBottomNav', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Hover Bottom Nav'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['hoverBottomNav']) ? $slideshow->config['general']['hoverBottomNav'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If false, slide buttons will be invisible.') . '</i>',
                    ]
                ]);

                echo $this->Form->input('config.general.showBarTimer', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Show Bar Timer'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['showBarTimer']) ? $slideshow->config['general']['showBarTimer'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If false, slide buttons will be invisible.') . '</i>',
                    ]
                ]);

                echo $this->Form->input('config.general.showCircleTimer', [
                    'type' => 'checkbox',
                    'label' => ['text' => __d('ittvn', 'Show Circle Timer'), 'class' => 'col-md-2'],
                    'class' => 'form-control',
                    'value' => isset($slideshow->config['general']['showCircleTimer']) ? $slideshow->config['general']['showCircleTimer'] : '',
                    'default' => 1,
                    'templates' => [
                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                        'checkbox' => '<label class="toggle col-md-1"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-7">' . __d('ittvn', 'If false, slide buttons will be invisible.') . '</i>',
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion-slideshow" href="#collapseLayers"> 
                    <i class="fa fa-lg fa-angle-down pull-right"></i> 
                    <i class="fa fa-lg fa-angle-up pull-right"></i> 
                    <strong><?= __d('ittvn', 'Layers Settings'); ?></strong>
                </a>
            </h4>
        </div>
        <div id="collapseLayers" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.layers.slideDirection', [
                            'type' => 'select',
                            'label' => __d('ittvn', 'Slide Direction'),
                            'class' => 'form-control',
                            'style' => 'width: 100%',
                            'options' => [
                                'left' => __d('ittvn', 'Left'),
                                'right' => __d('ittvn', 'Right'),
                                'top' => __d('ittvn', 'Top'),
                                'bottom' => __d('ittvn', 'Bottom'),
                                'fade' => __d('ittvn', 'Fade'),
                            ],
                            'value' => isset($slideshow->config['layers']['slideDirection']) ? $slideshow->config['layers']['slideDirection'] : '',
                            'default' => 'fade',
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form {{required}}" style="padding-bottom: 20px;">{{content}}</div>',
                                'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select> <i class="helptext col-md-12">' . __d('ittvn', 'Slide direction. New layers sliding FROM(!) this direction.') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.layers.slideDelay', [
                            'type' => 'number',
                            'label' => __d('ittvn', 'Slide Delay'),
                            'class' => 'form-control text-center',
                            'value' => isset($slideshow->config['layers']['slideDelay']) ? $slideshow->config['layers']['slideDelay'] : 9000,
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                                'input' => '<div class="input-group"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon">ms</span></div> <i class="helptext col-md-12">' . __d('ittvn', 'Time before the next slide will be loading.') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.layers.durationIn', [
                            'type' => 'number',
                            'label' => __d('ittvn', 'Duration In'),
                            'class' => 'form-control text-center',
                            'value' => isset($slideshow->config['layers']['durationIn']) ? $slideshow->config['layers']['durationIn'] : '',
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                                'input' => '<div class="input-group"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon">ms</span></div> <i class="helptext col-md-12">' . __d('ittvn', 'Duration of the slide-in animation.') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.layers.durationOut', [
                            'type' => 'number',
                            'label' => __d('ittvn', 'Duration Out'),
                            'class' => 'form-control text-center',
                            'value' => isset($slideshow->config['layers']['durationOut']) ? $slideshow->config['layers']['durationOut'] : '',
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                                'input' => '<div class="input-group"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon">ms</span></div> <i class="helptext col-md-12">' . __d('ittvn', 'Duration of the slide-out animation.') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.layers.easingIn', [
                            'type' => 'select',
                            'label' => __d('ittvn', 'Easing In'),
                            'class' => 'form-control',
                            'style' => 'width: 100%',
                            'options' => Configure::read('Slideshow.easing'),
                            'empty' => __d('ittvn', 'No Easing'),
                            'value' => isset($slideshow->config['layers']['easingIn']) ? $slideshow->config['layers']['easingIn'] : '',
                            'default' => '',
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form {{required}}" style="padding-bottom: 20px;">{{content}}</div>',
                                'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select> <i class="helptext col-md-12">' . __d('ittvn', 'Easing (type of transition) of the slide-in animation.') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.layers.easingOut', [
                            'type' => 'select',
                            'label' => __d('ittvn', 'Easing Out'),
                            'class' => 'form-control',
                            'style' => 'width: 100%',
                            'options' => Configure::read('Slideshow.easing'),
                            'empty' => __d('ittvn', 'No Easing'),
                            'value' => isset($slideshow->config['layers']['easingOut']) ? $slideshow->config['layers']['easingOut'] : '',
                            'default' => '',
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form {{required}}" style="padding-bottom: 20px;">{{content}}</div>',
                                'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select> <i class="helptext col-md-12">' . __d('ittvn', 'Easing (type of transition) of the slide-in animation.') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.layers.delayIn', [
                            'type' => 'number',
                            'label' => __d('ittvn', 'Delay In'),
                            'class' => 'form-control text-center',
                            'value' => isset($slideshow->config['layers']['delayIn']) ? $slideshow->config['layers']['delayIn'] : '',
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                                'input' => '<div class="input-group"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon">ms</span></div> <i class="helptext col-md-12">' . __d('ittvn', 'Delay time of the slide-in animation.') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('config.layers.delayOut', [
                            'type' => 'number',
                            'label' => __d('ittvn', 'Delay Out'),
                            'class' => 'form-control text-center',
                            'value' => isset($slideshow->config['layers']['delayOut']) ? $slideshow->config['layers']['delayOut'] : '',
                            'default' => 1,
                            'templates' => [
                                'inputContainer' => '<div class="form-group smart-form clearfix {{required}}">{{content}}</div>',
                                'input' => '<div class="input-group"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon">ms</span></div> <i class="helptext col-md-12">' . __d('ittvn', 'Delay time of the slide-out animation.') . '</i>',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>