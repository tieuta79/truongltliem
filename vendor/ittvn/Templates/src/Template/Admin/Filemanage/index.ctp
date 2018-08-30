<?php

use Cake\Core\Configure;
use Cake\Utility\Hash;

$this->assign('title', __d('ittvn', 'File Manage'));
$this->Html->addCrumb(__d('ittvn', 'Medias'), ['plugin' => 'Medias', 'controller' => 'Filemanage', 'action' => 'index']);
$this->Admin->adminScript('file');
?>
<div id="file_manager" class="row">
    <div class="col-xs-12 col-md-3">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
                <h2><?= __d('ittvn', 'File Manage'); ?></h2>
            </header>

            <div>
                <div class="widget-body">
                    <div class="widget-body-toolbar bg-color-white">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content" style="border: none">
                                <div class="file-manager">
                                    <h5><?= __d('ittvn', 'Source Tree'); ?></h5>
                                    <div id="galleries"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-9 animated fadeInRight">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-lg fa-folder"></i> </span>
                <div class="show_path">
                    <h2 class="medias-path">Path: <span></span></h2>
                </div>
            </header>

            <div>
                <div class="jarviswidget-editbox"></div>
                <div class="widget-body">
                    <div class="widget-body-toolbar bg-color-white">
                        <div class="box_code">
                            <textarea id="code"></textarea>
                            <button type="button" class="btn btn-success btn-sm save_file_manage" data-toggle="tooltip" title="" data-original-title="Save"><i class="fa fa-save"></i> Save</button>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
                        
