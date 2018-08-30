<?php if ($metatypes->count() > 0): ?>
    <ul id="sparks" class="">
        <?php foreach ($metatypes as $metatype): ?>
            <li class="sparks-info">
                <h5> <?= __d('ittvn', $metatype->name); ?> <span class="txt-color-blue"><i class="<?= $metatype->icon; ?>"></i> <?= count($metatype->contents); ?></span></h5>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>