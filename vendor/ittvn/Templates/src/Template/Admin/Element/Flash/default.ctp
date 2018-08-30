<?php
$class = 'message';
$iconClass = '';
switch ($params['class']) {
    case 'info':
        $iconClass = 'icon fa fa-info';
        break;
    case 'danger':
    case 'error':
        $iconClass = 'icon fa fa-ban';
        $class = 'danger';
        break;
    case 'warning':
        $iconClass = 'icon fa fa-warning';
        break;
    case 'success':
        $iconClass = 'icon fa fa-check';
        break;
    default:
        break;
}
?>
<div class="alert alert-<?= h($class) ?> alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php if(isset($hideTitle) && $hideTitle == true): ?>
    <h4><i class="<?= h($iconClass) ?>"></i> <?= __d('ittvn',ucfirst($params['class'])).'!'; ?></h4>
    <?php endif; ?>
    <?= h($message) ?>
</div>