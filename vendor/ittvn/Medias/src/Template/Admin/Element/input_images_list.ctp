<table class="table table-bordered" it_gallery="<?= $field_name; ?>">
    <thead>
        <tr>
            <th><?= __d('ittvn', 'Image'); ?></th>
            <th><?= __d('ittvn', 'Title'); ?></th>
            <th><?= __d('ittvn', 'Description'); ?></th>
            <th><?= __d('ittvn', 'Action'); ?></th>
        </tr>        
    </thead>
</table>

<div class="row">
    <div class="col-md-5 pull-right">
        <a href="javascript:void(0)" class="btn btn-success btn-sm" select-file="true" data-toggle="tooltip" title="" data-original-title="Select Images"><i class="fa fa-plus"></i> <?= __d('ittvn', 'Select Images'); ?></a> 
        <a href="#" class="btn btn-info btn-sm" data-toggle="tooltip" upload-file="true" title="" data-original-title="Uploads"><i class="fa fa-cloud-upload"></i> <?= __d('ittvn', 'Uploads'); ?></a>
    </div>
</div>

<div class="row list_preview"></div> 