<?= $this->Form->create($locale); ?>
<div class="modal-body">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><i class="fa fa-bars modal-icon"></i> <?= __d('ittvn', 'Add Locale'); ?></h4>
    </div>
    <div class="row">              
        <div class="col-md-12">
            <div class="modal-body">
                <?php
                echo $this->Form->input('domain', ['type' => 'select', 'options' => $domain,'class' => 'form-control']);
                echo $this->Form->input('msgid', [
                    'type' => 'textarea',
                    'label' => __d('ittvn', 'Static text'),
                    'class' => 'form-control'
                ]);
                if ($languages->count() > 0) {
                    foreach ($languages as $language) {
                        echo $this->Form->input('language_id.' . $language->id, [
                            'type' => 'textarea',
                            'label' => $language->name,
                            'class' => 'form-control'
                        ]);
                    }
                }
                ?>                                      
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary submit_ajax"><?= __d('ittvn', 'Save'); ?></button>
</div>
<?= $this->Form->end(); ?>