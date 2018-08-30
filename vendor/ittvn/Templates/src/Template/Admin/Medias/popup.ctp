<?php
$css = [
    'jquery.contextMenu.min'
];
echo $this->Html->css($css);

$scripts = [
    'plugin/jquery-contextmenu/jquery.contextMenu.min',
    'plugin/jquery-contextmenu/jquery.ui.position.min',
    'plugin/dropzone/dropzone.min',
    'media_popup'
];
echo $this->Html->script($scripts);
?>
<div class="modal-body modal-upload">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1">Uploads</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2">Medias</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    <form id="it_uploads" class="dropzone" action="<?= Cake\Routing\Router::url(['plugin' => 'Medias', 'controller' => 'Medias', 'action' => 'upload']); ?>">
                        <input type="hidden" value="" name="gallery_id" id="gallery_id" value="0" />
                        <div class="dropzone-previews"></div>
                    </form> 
                </div>
            </div>
            <div id="tab-2" class="tab-pane">
                <div class="panel-body">
                    <div class="box_search_image" style="padding-bottom: 20px;">
                        <div class="input-group">
                            <input type="text" placeholder="Filename" class="form-control" />
                            <span class="input-group-btn"> 
                                <button type="button" class="btn btn-primary">Search</button> 
                                <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button"><span class="caret"></span> <span class="show_folder">All Folders</span></button>                                
                                <ul class="dropdown-menu pull-right">
                                    <li><a class="choose_folder" href="javascript:void(0)" value="" title="All Folders">All Folders</a></li>
                                    <?php if (count($galleries) > 0): ?>
                                        <?php foreach ($galleries as $id => $gallery): ?>
                                            <li><a class="choose_folder" href="javascript:void(0)" value="<?= $id; ?>" title="<?= $gallery; ?>"><?= $gallery; ?></a></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>                                
                            </span>
                        </div>            
                    </div>
                    <div class="hr-line-dashed"></div>
                    <input type="hidden" id="element_return" value="#<?= $this->request->query('element_return'); ?>" />
                    <input type="hidden" id="element_multiple" value="<?= $this->request->query('multiple'); ?>" />
                    <div class="row">
                        <div class="col-lg-12 no-padding" data-scroll="true" data-height="250">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($this->request->query('multiple')==1): ?>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" id="insert_files" class="btn btn-primary"><?= __d('ittvn', 'Insert'); ?></button>
    </div>
<?php endif; ?>