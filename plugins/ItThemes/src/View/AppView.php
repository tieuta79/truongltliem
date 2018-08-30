<?php

namespace ItThemes\View;

use Cake\View\View;
use Cake\Core\App;
use Cake\Core\Plugin;

class AppView extends View {

    public function initialize() {
        $pathHelper = App::path('View/Helper', $this->theme)[0];
        $pathConfig = Plugin::path($this->theme) . 'config' . DS;        
        
        if (file_exists($pathHelper . 'LayoutHelper.php')) {
            $this->loadHelper($this->theme . '.Layout');
        } else {
            $this->loadHelper('Ittvn.Layout');
        }        
        
        if (file_exists($pathHelper . 'ContentHelper.php')) {
            $this->loadHelper($this->theme . '.Content');
        } else {
            $this->loadHelper('Contents.Content');
        }
    }

}
