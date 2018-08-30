<table class="table table-bordered" it_gallery="<?= $field_name; ?>">
    <thead>
        <tr>
            <th><?= __d('ittvn', 'Image'); ?></th>
            <th><?= __d('ittvn', 'Title'); ?></th>
            <th><?= __d('ittvn', 'Description'); ?></th>
            <th><?= __d('ittvn', 'Action'); ?></th>
        </tr>        
    </thead>
    <?php if (isset($photos)): ?>
        <tbody>
            <?php foreach ($photos as $k => $image): ?>
                <tr it_id="<?= $image->id; ?>" sort="<?= $k; ?>">
                    <td>
                        <?= $this->Html->image($image->name, ['width' => 50]); ?>
                        <input type="hidden" name="images[<?= $k; ?>][id]" value="<?= $image->id; ?>" class="form-control" />
                        <input type="hidden" name="images[<?= $k; ?>][name]" value="<?= $image->name; ?>" class="form-control" />
                        <input type="hidden" name="images[<?= $k; ?>][order]" value="<?= $k; ?>" class="form-control it_order" size="3" />
                        <input type="hidden" name="images[<?= $k; ?>][property_id]" value="<?= $image->property_id; ?>" class="form-control" />
                    </td>         
                    <td><input type="text" name="images[<?= $k; ?>][title]" value="<?= $image->title; ?>" class="form-control" /></td>
                    <td><textarea name="images[<?= $k; ?>][description]" class="form-control"><?= $image->description; ?></textarea></td>
                    <td class="text-center"><a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip" delete-item-file="true" title="Delete File"><i class="fa fa-trash-o"></i></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>

<div class="row">
    <div class="col-md-5 pull-right">
        <a href="javascript:void(0)" class="btn btn-success btn-sm" select-file="true" data-toggle="tooltip" title="" data-original-title="Select Images"><i class="fa fa-plus"></i> <?= __d('ittvn', 'Select Images'); ?></a> 
        <a href="#" class="btn btn-info btn-sm" data-toggle="tooltip" upload-file="true" title="" data-original-title="Uploads"><i class="fa fa-cloud-upload"></i> <?= __d('ittvn', 'Uploads'); ?></a>
    </div>
</div>

<div class="row list_preview"></div> 