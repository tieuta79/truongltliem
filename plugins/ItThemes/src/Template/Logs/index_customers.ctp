<?php

use Settings\Utility\Setting;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Logs'));
$this->Html->addCrumb(__d('ittvn', 'Logs'), $this->request->here);
?>
<?php
$this->start('left');
echo $this->cell('ItThemes.Theme::menuCustomer');
$this->end();
?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-top">
                <h3>
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i> 
                    <strong><?= __d('ittvn', 'Lịch sử đăng nhập'); ?></strong>
                </h3>
            </div> 
            <div class="box-content">
                <div class="panel-body no-padding">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th class="text-md-center"><?= __d('ittvn', 'Ip'); ?></th>
                                <th class="text-md-center"><?= __d('ittvn', 'Browser'); ?></th>
                                <th class="text-md-center"><?= __d('ittvn', 'Date'); ?></th>
                            </tr>
                        </thead>
                        <?php if ($logs->count() > 0): ?>
                            <tbody>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td><?= $log->ip; ?></td>
                                        <td><?= $log->browser; ?></td>
                                        <td class="text-md-center"><?= !empty($log->created) ? $log->created->format($setting->getOption('Sites.format_time') . ' ' . str_replace('-', '/', $setting->getOption('Sites.format_date'))) : ''; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>