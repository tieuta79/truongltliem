<?php

use Cake\Core\Configure;

$this->assign('title', __d('ittvn', 'Dashboard'));
$dashboard = $this->Layout->Prdashboard();
?>
<div class="row dashboard">
    <div class="col-md-7">
        <?php if (isset($dashboard['left']) && !empty($dashboard['left'])): ?>
            <?php foreach ($dashboard['left'] as $left): ?>
                <?php if (isset($left['links']) && !empty($left['links'])): ?>
                    <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
                        <header>
                            <h2>
                                <?php if (isset($left['icon'])): ?>
                                    <i class="<?= $left['icon']; ?>" aria-hidden="true"></i> 
                                <?php endif; ?>
                                <?= $left['label']; ?>
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body shortcus">
                                <?php foreach ($left['links'] as $k => $link): ?>
                                    <?php if ($k == 0 || $k % 6 == 0): ?>
                                        <div class="row">
                                        <?php endif; ?>

                                        <div class="col-xs-4 col-md-2 text-center">
                                            <?=
                                            $this->Html->link(
                                                    '<i class="' . $link['icon'] . '"></i> <span>' . $link['label'] . '</span>', $link['url'], ['escape' => false, 'class' => 'btn btn-default']
                                            );
                                            ?>
                                        </div>

                                        <?php if (($k != 0 && $k % 5 == 0) || (count($left['links']) == ($k + 1))): ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="col-md-5">
        <div class="panel-group smart-accordion-default" id="sumary">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sumary" href="#userlogs">
                            <i class="fa fa-lg fa-angle-down pull-right"></i> 
                            <i class="fa fa-lg fa-angle-up pull-right"></i> 
                            Nháº­t kĂ½ Ä‘Äƒng nháº­p 
                        </a>
                    </h4>
                </div>
                <div id="userlogs" class="panel-collapse collapse in">
                    <?= $this->cell('Users.Logs::recent'); ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#sumary" href="#recentposts" class="collapsed"> <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i> Tin Ä‘Ă£ Ä‘Äƒng gáº§n Ä‘Ă¢y </a></h4>
                </div>
                <div id="recentposts" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?= $this->cell('Contents.Content::recent'); ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#sumary" href="#charts" class="collapsed"> <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i> Thá»‘ng kĂª </a></h4>
                </div>
                <div id="charts" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?= $this->cell('Contents.Content::counter'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>