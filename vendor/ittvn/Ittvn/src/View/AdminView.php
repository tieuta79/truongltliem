<?php

namespace Ittvn\View;

use Cake\View\View;
use Cake\Core\App;
use Cake\Core\Plugin;

class AdminView extends View {

    public function initialize() {
        $pathHelper = App::path('View/Helper', $this->theme)[0];
        $pathConfig = Plugin::path($this->theme) . 'config' . DS;

        if (file_exists($pathHelper . 'AdminHelper.php')) {
            $this->loadHelper($this->theme . '.Admin');
        } else {
            $this->loadHelper('Templates.Admin');
        }

        if (file_exists($pathHelper . 'LayoutHelper.php')) {
            $this->loadHelper($this->theme . '.Layout');
        } else {
            $this->loadHelper('Ittvn.Layout');
        }

        if (file_exists($pathHelper . 'IttvnHtmlHelper.php')) {
            $this->loadHelper('Html', [
                'className' => $this->theme . '.IttvnHtml'
            ]);
        } else {
            $this->loadHelper('Html', [
                'className' => 'Templates.IttvnHtml'
            ]);
        }
        
        if (file_exists($pathHelper . 'ContentHelper.php')) {
            $this->loadHelper($this->theme . '.Content');
        } else {
            $this->loadHelper('Contents.Content');
        }      

        if (file_exists($pathConfig . 'form-templates.php')) {
            $this->loadHelper('Form', [
                'templates' => $this->theme . '.form-templates',
            ]);
        } else {
            $this->loadHelper('Form', [
                'templates' => 'Templates.form-templates',
            ]);
        }
    }
}
