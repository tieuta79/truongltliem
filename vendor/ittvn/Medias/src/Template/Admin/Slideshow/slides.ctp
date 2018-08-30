<?php
$this->assign('title', __d('ittvn', 'Add slides'));
$this->Admin->adminScript('slideshow');
$this->Html->addCrumb(__d('ittvn', 'Slideshow'), ['controller' => 'Slideshow', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Add Slides'), $this->request->here);
?>
<div class="row">
    <div class="col-md-8">
        <?= $this->Flash->render('auth'); ?>
        <?= $this->Flash->render(); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
            <header>
                <div class="jarviswidget-ctrls" role="menu">              
                    <?php
                    echo $this->Html->link(
                            '<i class="fa fa-plus"></i>', ['plugin' => 'Medias', 'controller' => 'Slideshow', 'action' => 'addSlide', $this->request->params['pass'][0]], ['class' => 'button-icon jarviswidget-add-new', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'Add new'), 'escape' => false]
                    );
                    ?>                  
                </div>  
                <h2><?= __d('ittvn', 'Slides for slideshow'); ?></h2>
            </header>
            <div>
                <div class="widget-body">
                    <?php if (isset($slideshow->config['images']) && count($slideshow->config['images']) > 0): ?>
                        <ul class="nav nav-tabs" id="demo-pill-nav">
                            <?php
                            $i = 0;
                            foreach ($slideshow->config['images'] as $key => $image):
                                ?>
                                <li class="<?= $i++ == 0 ? 'active' : ''; ?>">
                                    <?= $this->Html->link(__d('ittvn', $image['title']), '#tab-' . $key, ['data-toggle' => 'tab']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="tab-content">
                            <br />
                            <?php
                            $i = 0;
                            foreach ($slideshow->config['images'] as $key => $image):
                                ?>
                                <div class="tab-pane <?= $i++ == 0 ? 'active' : ''; ?>" id="tab-<?= $key; ?>" image_id="<?= $key; ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel-group smart-accordion-default" id="accordion-layers-<?= $key; ?>">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion-layers-<?= $key; ?>" href="#collapseLayers-<?= $key; ?>"> 
                                                                <i class="fa fa-lg fa-angle-down pull-right"></i> 
                                                                <i class="fa fa-lg fa-angle-up pull-right"></i> 
                                                                <?= __d('ittvn', 'Slide Images and Layers'); ?>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseLayers-<?= $key; ?>" class="panel-collapse collapse in">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <?php
                                                                    echo $this->Form->input('images.' . $key . '.bg', [
                                                                        'type' => 'radio',
                                                                        'multiple' => true,
                                                                        'label' => false,
                                                                        'class' => 'form-control',
                                                                        'options' => [
                                                                            0 => __d('ittvn', 'Image BG'),
                                                                            1 => __d('ittvn', 'Transparent BG'),
                                                                            2 => __d('ittvn', 'Solid BG'),
                                                                        ],
                                                                        'default' => 1,
                                                                        'templates' => [
                                                                            'inputContainer' => '<div class="form-group smart-form {{required}}">{{content}}</div>',
                                                                            'nestingLabel' => '<label class="radio"{{attrs}}>{{hidden}}{{input}} {{text}}</label>',
                                                                            'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}> <i></i>',
                                                                        ]
                                                                    ]);
                                                                    ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <?php
                                                                    echo $this->Form->button(__d('ittvn', 'Change Image'), ['type' => 'button', 'disabled' => true, 'class' => 'btn btn-success btn_change_bg']);
                                                                    ?>
                                                                    <br /><br />
                                                                    <?php
                                                                    echo $this->Form->input('images.' . $key . '.bg_color', [
                                                                        'type' => 'text',
                                                                        'data-type' => 'colorpicker',
                                                                        'label' => false,
                                                                        'disabled' => true,
                                                                        'class' => 'form-control',
                                                                        'value' => isset($image['bg_color']) ? $image['bg_color'] : '',
                                                                        'templates' => [
                                                                            'inputContainer' => '<div class="form-group row {{required}}">{{content}}</div>',
                                                                            'input' => '<div class="col-md-6"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                                                                        ]
                                                                    ]);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <?php
                                                                    echo $this->Form->button(__d('ittvn', 'Add layer'), ['type' => 'button', 'class' => 'btn btn-info btn_add_layer']);
                                                                    ?>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <?php
                                                                    echo $this->Form->button(__d('ittvn', 'Add layer: Image'), ['type' => 'button', 'class' => 'btn btn-info btn_add_layer_image']);
                                                                    ?>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <?php
                                                                    echo $this->Form->button(__d('ittvn', 'Add layer: Video'), ['type' => 'button', 'class' => 'btn btn-info btn_add_layer_video']);
                                                                    ?>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <?php
                                                                    echo $this->Form->button(__d('ittvn', 'Delete layer'), ['type' => 'button', 'class' => 'btn btn-danger btn_delete_layer']);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-md-6">
                                            <div class="panel-group smart-accordion-default" id="accordion-slideshow-<?= $key; ?>">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion-slideshow-<?= $key; ?>" href="#collapseGeneral-<?= $key; ?>"> 
                                                                <i class="fa fa-lg fa-angle-down pull-right"></i> 
                                                                <i class="fa fa-lg fa-angle-up pull-right"></i> 
                                                                <?= __d('ittvn', 'General Slide Settings'); ?>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseGeneral-<?= $key; ?>" class="panel-collapse collapse in">
                                                        <div class="panel-body">
                                                            <?php
                                                            echo $this->Form->input('images.' . $key . '.title', [
                                                                'type' => 'text',
                                                                'label' => ['text' => __d('ittvn', 'Title'), 'class' => 'col-md-12'],
                                                                'class' => 'form-control',
                                                                'value' => $image['title'],
                                                                'templates' => [
                                                                    'inputContainer' => '<div class="form-group clearfix {{required}}">{{content}}</div>',
                                                                    'input' => '<div class="col-md-6"><input type="{{type}}" name="{{name}}"{{attrs}}/></div> <i class="helptext col-md-6">' . __d('ittvn', 'The title of the slide, will be shown in the slides list.') . '</i>',
                                                                ]
                                                            ]);

                                                            echo $this->Form->input('images.' . $key . '.status', [
                                                                'type' => 'checkbox',
                                                                'label' => ['text' => __d('ittvn', 'Status'), 'class' => 'col-md-1'],
                                                                'class' => 'form-control',
                                                                'value' => isset($image['status']) ? $image['status'] : 0,
                                                                'default' => 1,
                                                                'templates' => [
                                                                    'inputContainer' => '<div class="form-group smart-form clearfix {{required}}" style="padding-left: 15px;">{{content}}</div>',
                                                                    'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                                                                    'checkbox' => '<label class="toggle col-md-3"><input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}> <i data-swchoff-text="' . __d('ittvn', 'TRUE') . '" data-swchon-text="' . __d('ittvn', 'FALSE') . '"></i></label> <i class="helptext col-md-6">' . __d('ittvn', 'The status of the slide. The false slide will be excluded from the slider.') . '</i>',
                                                                ]
                                                            ]);

                                                            echo $this->Form->input('images.' . $key . '.transition2d', [
                                                                'type' => 'text',
                                                                'label' => ['text' => __d('ittvn', 'Transition 2d'), 'class' => 'col-md-12'],
                                                                'class' => 'form-control',
                                                                'value' => isset($image['transition2d']) ? $image['transition2d'] : '',
                                                                'templates' => [
                                                                    'inputContainer' => '<div class="form-group clearfix {{required}}">{{content}}</div>',
                                                                    'input' => '<div class="col-md-6"><input type="{{type}}" name="{{name}}"{{attrs}}/></div> <i class="helptext col-md-6">' . __d('ittvn', 'Effect translation 2d. If null is all') . '</i>',
                                                                ]
                                                            ]);

                                                            echo $this->Form->input('images.' . $key . '.transition3d', [
                                                                'type' => 'text',
                                                                'label' => ['text' => __d('ittvn', 'Transition 3d'), 'class' => 'col-md-12'],
                                                                'class' => 'form-control',
                                                                'value' => isset($image['transition3d']) ? $image['transition3d'] : '',
                                                                'templates' => [
                                                                    'inputContainer' => '<div class="form-group clearfix {{required}}">{{content}}</div>',
                                                                    'input' => '<div class="col-md-6"><input type="{{type}}" name="{{name}}"{{attrs}}/></div> <i class="helptext col-md-6">' . __d('ittvn', 'Effect translation 3d. If null is all') . '</i>',
                                                                ]
                                                            ]);
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <?php
                                                                    echo $this->Form->input('images.' . $key . '.slideDelay', [
                                                                        'type' => 'number',
                                                                        'label' => __d('ittvn', 'Slide Delay'),
                                                                        'class' => 'form-control text-center',
                                                                        'value' => isset($image['slideDelay']) ? $image['slideDelay'] : '',
                                                                        'templates' => [
                                                                            'inputContainer' => '<div class="form-group smart-form clearfix {{required}}" style="padding-left: 15px;">{{content}}</div>',
                                                                            'input' => '<div class="input-group"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon">ms</span></div> <i class="helptext col-md-12">' . __d('ittvn', 'Time before the next slide will be loading.') . '</i>',
                                                                        ]
                                                                    ]);
                                                                    ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <?php
                                                                    echo $this->Form->input('images.' . $key . '.timeshift', [
                                                                        'type' => 'number',
                                                                        'label' => __d('ittvn', 'Time Shift'),
                                                                        'class' => 'form-control text-center',
                                                                        'value' => isset($image['timeshift']) ? $image['timeshift'] : '',
                                                                        'templates' => [
                                                                            'inputContainer' => '<div class="form-group smart-form clearfix {{required}}" style="padding-left: 15px;">{{content}}</div>',
                                                                            'input' => '<div class="input-group"><input type="{{type}}" name="{{name}}"{{attrs}}/><span class="input-group-addon">ms</span></div> <i class="helptext col-md-12">' . __d('ittvn', 'Time for change effect.') . '</i>',
                                                                        ]
                                                                    ]);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="custom_slideshow-<?= $key; ?>" class="bordered padding-10">
                                                <div class="layerslider" style="width: <?= $slideshow->config['layout']['width']; ?>px; height: <?= $slideshow->config['layout']['height']; ?>px;">
                                                    <div class="ls-slide" data-ls="slidedelay: 7000; transition2d: 75,79;">
                                                        <img src="/uploads/2016/12/21/6.jpg" class="ls-bg img-responsive" alt="ddd"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel-group smart-accordion-default" id="accordion-layer-general-<?= $key; ?>">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion-layer-general-<?= $key; ?>" href="#collapseLayerGeneral-<?= $key; ?>"> 
                                                                <i class="fa fa-lg fa-angle-down pull-right"></i> 
                                                                <i class="fa fa-lg fa-angle-up pull-right"></i> 
                                                                <?= __d('ittvn', 'Layer General'); ?>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseLayerGeneral-<?= $key; ?>" class="panel-collapse collapse in">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <?php
                                                                echo $this->Form->input('images.' . $key . '.layer.text', [
                                                                    'type' => 'textarea',
                                                                    'label' => __d('ittvn', 'Text / Html'),
                                                                    'class' => 'form-control',
                                                                    'value' => isset($image['text']) ? $image['text'] : '',
                                                                    'templates' => [
                                                                        'inputContainer' => '<div class="form-group smart-form clearfix {{required}}" style="padding-left: 15px;">{{content}}</div>',
                                                                    ]
                                                                ]);
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12" style="margin-left: 15px;padding-top: 10px;padding-bottom: 10px;">
                                                                <label><?= __d('ittvn', 'Style'); ?></label> <br />
                                                                <button class="btn btn-xs"><i class="fa fa-bold" aria-hidden="true"></i></button> 
                                                                <button class="btn btn-xs"><i class="fa fa-underline" aria-hidden="true"></i></button> 
                                                                <button class="btn btn-xs"><i class="fa fa-italic" aria-hidden="true"></i></button> 
                                                                <button class="btn btn-xs"><i class="fa fa-font" style="color:black;background-color:yellow;"></i></button> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion-layer-general-<?= $key; ?>" href="#collapseLayerAnimation-<?= $key; ?>"> 
                                                                <i class="fa fa-lg fa-angle-down pull-right"></i> 
                                                                <i class="fa fa-lg fa-angle-up pull-right"></i> 
                                                                <?= __d('ittvn', 'Layer Animation'); ?>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseLayerAnimation-<?= $key; ?>" class="panel-collapse collapse">
                                                        <br /><br /><br /><br /><br />
                                                    </div>
                                                </div>

                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion-layer-general-<?= $key; ?>" href="#collapseLayerLinks-<?= $key; ?>"> 
                                                                <i class="fa fa-lg fa-angle-down pull-right"></i> 
                                                                <i class="fa fa-lg fa-angle-up pull-right"></i> 
                                                                <?= __d('ittvn', 'Layer Links & Advanced Params '); ?>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseLayerLinks-<?= $key; ?>" class="panel-collapse collapse">
                                                        <br /><br /><br /><br /><br />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <h4 class="panel-title"><?= __d('ittvn', 'Layers Timing'); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>                                    
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>    
</div>