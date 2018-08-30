<?php

use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\Routing\Router;

$this->assign('title', __d('ittvn', 'Medias'));
$this->Html->addCrumb(__d('ittvn', 'Medias'), ['plugin' => 'Medias', 'controller' => 'Medias', 'action' => 'index']);
$this->Admin->adminScript('media');
?>
<div class="row">
    <div class="col-xs-12 col-md-3">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
                <h2><?= __d('ittvn', 'Medias'); ?></h2>
            </header>

            <div>
                <div class="widget-body">
                    <div class="widget-body-toolbar bg-color-white">
                        <?php
                        echo $this->Html->link('<i class="fa fa-plus"></i>', ['plugin' => 'Medias', 'controller' => 'Galleries', 'action' => 'add'], [
                            'escape' => false,
                            'data-toggle' => 'modal',
                            'data-target' => '#modal_ajax',
                            'rel' => 'tooltip',
                            'data-placement' => 'top',
                            'data-original-title' => __d('ittvn', 'Add Folder'),
                            'class' => 'btn btn-xs btn-success add_gallery',
                            'data-path' => Router::url(['plugin' => 'Medias', 'controller' => 'Galleries', 'action' => 'add'])
                        ]) . '&nbsp;';

                        echo $this->Html->link('<i class="fa fa-trash"></i>', 'javascript:void(0)', [
                            'escape' => false,
                            'rel' => 'tooltip',
                            'data-placement' => 'top',
                            'data-original-title' => __d('ittvn', 'Delete Folder'),
                            'class' => 'btn btn-xs btn-danger delete_gallery',
                            'data-path' => Router::url(['plugin' => 'Medias', 'controller' => 'Galleries', 'action' => 'delete'])
                        ]) . '&nbsp;';

                        echo $this->Html->link('<i class="fa fa-edit"></i>', ['plugin' => 'Medias', 'controller' => 'Galleries', 'action' => 'edit'], [
                            'escape' => false,
                            'data-toggle' => 'modal',
                            'data-target' => '#modal_ajax',
                            'rel' => 'tooltip',
                            'data-placement' => 'top',
                            'data-original-title' => __d('ittvn', 'Rename Folder'),
                            'class' => 'btn btn-xs btn-info edit_gallery',
                            'data-path' => Router::url(['plugin' => 'Medias', 'controller' => 'Galleries', 'action' => 'edit'])
                        ]);
                        ?>
                    </div>

                    <!-- Modal -->
                    <div id="edit-galleries-popup" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Update Medias</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="smart-form">
                                        <div class="msg"></div>
                                        <input type="hidden" name="gallery_id" class="gallery-id-update">
                                        <input type="text" name="gallery" class="input-sm gallery-name-update">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-update-gallery">Update</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tree smart-form">
                        <?= $this->Admin->galleries($galleries); ?>
                    </div>
                </div>
            </div>
        </div>    
    </div>

    <div class="col-xs-12 col-md-9">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-lg fa-folder"></i> </span>
                <h2 class="medias-path">Folders</h2>
            </header>

            <div>
                <div class="jarviswidget-editbox">

                </div>

                <div class="widget-body">
                    <div class="widget-body-toolbar bg-color-white">
                        <form class="form-inline" role="form">
                            <div class="row">
                                <div class="col-sm-12 col-md-10">
                                    <?= $this->Form->input('media_filter_text', ['type' => 'text', 'label' => false, 'class' => 'form-control input-sm', 'placeholder' => __d('ittvn', 'Titile or description')]); ?> 
                                    <?=
                                    $this->Form->input('media_filter_date', [
                                        'type' => 'date',
                                        'label' => false,
                                        'maxYear' => date('Y'),
                                        'placeholder' => __d('ittvn', 'Titile or description'),
                                        'templates' => ['dateWidget' => '{{month}} {{year}}', 'select' => '<select name="{{name}}"{{attrs}} class="form-control input-sm">{{content}}</select>',],
                                        'empty' => ['month' => __d('ittvn', 'Choose month'), 'year' => __d('ittvn', 'Choose year')]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-12 col-md-2 text-align-right">
                                    <button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-warning">
                                        <i class="fa fa-upload" ></i> Upload
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

                <!-- gallery -->
                <div class="row ">
                    <!-- SuperBox -->
                    <div class="superbox col-sm-12">
                        <div class="superbox-float"></div>
                    </div>
                    <!-- /SuperBox -->

                    <div class="superbox-show" style="height:300px; display: none"></div>
                    <div id="superbox-list-pattern" style="display:none">
                        <div class="superbox-list">
                            <img src="{path}" data-superbox-id="{id}" data-type="" data-date="{date}" data-img="{path}" alt="{description}" title="{title}" class="superbox-img thumbnail" />
                        </div>
                    </div>
                    <?= $this->Html->script(['plugin/superbox/superbox.min.js'], ['block' => 'scriptBottom']) ?>

                </div>

            </div>

        </div>
    </div>
    <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><?= __d('ittvn', 'Upload Medias'); ?></h4>
                </div>
                <div class="modal-body">
                    <form id="upload-dropzone" class="dropzone" action="<?= Router::url(['plugin' => 'Medias', 'controller' => 'Medias', 'action' => 'upload']); ?>">
                        <input type="hidden" value="" name="gallery_id" id="gallery_id" />
                        <div class="dropzone-previews">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  
</div>