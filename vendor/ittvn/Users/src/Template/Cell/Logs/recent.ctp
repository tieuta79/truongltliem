<?php
use Settings\Utility\Setting;
$settings = new Setting();
?>
<div class="panel-body no-padding">
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th><?= __d('ittvn','Ip'); ?></th>
                <th><?= __d('ittvn','Browser'); ?></th>
                <th><?= __d('ittvn','Date'); ?></th>
            </tr>
        </thead>
        <?php if($logs->count() > 0):  ?>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $log->ip; ?></td>
                <td><?= $log->browser; ?></td>
                <td class="text-center"><?= !empty($log->created)?$log->created->format($settings->getOption('Sites.format_time').' '. str_replace('-', '/', $settings->getOption('Sites.format_date'))):''; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <?php endif; ?>
    </table>
</div>