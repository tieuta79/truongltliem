<?php if (isset($features) && $features->count()): ?>
<div id="single_tour_feat">
    <ul>
        <?php foreach ($features as $feature): ?>
        <li><i class="<?= $feature->Icon_meta; ?>"></i><?= $feature->name; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>