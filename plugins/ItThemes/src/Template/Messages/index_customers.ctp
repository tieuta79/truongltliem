<?php

use Settings\Utility\Setting;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Messages'));
$this->Html->addCrumb(__d('ittvn', 'Messages'), $this->request->here);
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
                    <strong><?= __d('ittvn', 'Thông báo'); ?></strong>
                </h3>
            </div> 
            <div class="box-content">
                <div class="panel-body no-padding">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th class="text-md-center"><?= __d('ittvn', 'Date'); ?></th>
                                <th class="text-md-center"><?= __d('ittvn', 'Title'); ?></th>
                                <th class="text-md-center"><?= __d('ittvn', 'Message'); ?></th>
                                <th class="text-md-center"><?= __d('ittvn', 'Sender'); ?></th>
                                <th class="text-md-center"><?= __d('ittvn', 'Priority'); ?></th>
                            </tr>
                        </thead>
                        <?php if ($messages->count() > 0): ?>
                            <tbody>
                                <?php foreach ($messages as $message): ?>
                                    <tr class="unread">
                                        <td class="text-md-center">
                                            <?= !empty($message->created) ? $message->created->format(str_replace('-', '/', $setting->getOption('Sites.format_date')) . ' ' . $setting->getOption('Sites.format_time')) : ''; ?>
                                        </td>
                                        <td><?= $message->title; ?></td>
                                        <td><?= $message->message; ?></td>
                                        <td class="text-md-center"><?= $message->sender->first_name . ' ' . $message->sender->middle_name . ' ' . $message->sender->last_name; ?></td>
                                        <td class="text-md-center"><?= Configure::read('Messages.priority.'.$message->priority); ?></td>
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