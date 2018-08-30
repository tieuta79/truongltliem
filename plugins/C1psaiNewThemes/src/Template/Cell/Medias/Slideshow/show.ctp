<?php
use Cake\Utility\Text;
use Cake\Routing\Router;
use Cake\Core\Configure;
$id = Text::uuid();
?>

<?php
if ($medias->count() > 0):

    if(Configure::read('Slideshow.flag') == false){
        echo $this->Html->css([
            '/medias/css/layerslider'
            ]
        );
        echo $this->Html->script([
        '/medias/js/greensock',
        '/medias/js/layerslider.transitions',
        '/medias/js/layerslider.kreaturamedia.jquery',
            //'/medias/js/slide.js?hover=true'
            ]
    );
        Configure::write('Slideshow.flag' , true); 
    }
    

    
    ?>

    <div id="slider-wrapper-<?= $id; ?>">
        <div id="layerslider-<?= $id; ?>" style="width: <?= $config['layout']['width']; ?>px; height: <?= $config['layout']['height']; ?>px;">
            <?php foreach ($medias as $media): ?>
                <div class="ls-slide" data-ls="slidedelay: 7000; transition2d: 75,79;">
                    <img src="<?= $media->url; ?>" class="ls-bg" alt="<?= $media->title; ?>"/>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php 
    $layersilder_features = [
        'skin' => $config['layout']['skin'],
        'responsive' => $config['layout']['responsive'] == 1 ? true : false,
        'pauseOnHover' => $config['general']['hover'] == 1 ? true : false,
        'skinsPath' => $this->request->webroot.'medias'.DS.'skins'.DS,       
        'autoStart' =>  $config['general']['autoStart'] == 1 ? false : true,
        'pauseOnHover' => $config['general']['hover'] == 1 ? false : true,
        'randomSlideshow' => $config['general']['randomSlideshow'] == 1 ? false : true, 
        'imgPreload' => $config['general']['imgPreload'] == 1 ? false : true, 
        'navPrevNext' => $config['general']['navPrevNext'] == 1 ? false : true, 
        'navStartStop' => $config['general']['navStartStop'] == 1 ? false : true, 
        'navButtons' => $config['general']['navButtons'] == 1 ? false : true, 
        'thumbnailNavigation' => $config['general']['thumbnailNavigation'],
        'tnWidth' => $config['general']['tnWidth'] ,
        'tnHeight' => $config['general']['tnHeight'] ,
        'hoverPrevNext' => $config['general']['hoverPrevNext'] == 1 ? false : true, 
        'hoverBottomNav' => $config['general']['hoverBottomNav'] == 1 ? false : true, 
        'showBarTimer' => $config['general']['showBarTimer'] == 1 ? false : true, 
        'showCircleTimer' => $config['general']['showCircleTimer'] == 1 ? false : true, 
        'slideDirection' => $config['layers']['slideDirection'],
        'slideDelay' => $config['layers']['slideDelay'],
        'durationIn' => $config['layers']['durationIn'],
        'durationOut' => $config['layers']['durationOut'],
        'easingIn' => $config['layers']['easingIn'],
        'easingOut' => $config['layers']['easingOut'],
        'delayIn' => $config['layers']['delayIn'],
        'delayOut' => $config['layers']['delayOut'],
        ];   
    //echo json_encode($layersilder_features);
?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#layerslider-<?= $id; ?>").layerSlider(
            <?= json_encode($layersilder_features);  ?>        
            );
        });
    </script>
<?php endif; ?>