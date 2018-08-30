<li <?= $deep != 0 ? 'style="display:none"' : ''; ?> data-path="<?= $gallery->name; ?>" data-id="<?= $gallery->id; ?>" id="tree-node-<?= $gallery->id; ?>">
    <span><i class="fa fa-lg fa-folder"></i> <?= $gallery->name; ?></span>
    <?php
    if (count($gallery->children) > 0):
        echo $this->Admin->galleries($gallery->children, ++$deep);
    endif;
    ?>
</li>