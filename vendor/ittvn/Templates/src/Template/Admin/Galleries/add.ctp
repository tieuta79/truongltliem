<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title"><?= sprintf(__d('ittvn', 'Add folder of %s'), $parent); ?></h4>
</div>
<?= $this->Form->create($gallery); ?>
<div class="modal-body modal-gallery">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?=
                $this->Form->input('name', [
                    'label' => __d('ittvn', 'Folder name'),
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <?= $this->Form->button(__d('ittvn', 'Create'), ['class' => 'btn btn-primary btn_add_folder']) ?>
</div>