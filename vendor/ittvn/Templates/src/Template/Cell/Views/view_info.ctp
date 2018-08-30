<?php if (count($views) > 0): ?>
    <?php foreach ($views as $field): ?>
        <dl class="dl-horizontal clearfix">
            <?= $field['value']; ?>
        </dl>
    <?php endforeach; ?>
<?php endif; ?>