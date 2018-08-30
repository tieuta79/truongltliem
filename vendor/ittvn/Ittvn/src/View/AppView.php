<?php

namespace Ittvn\View;

use Cake\View\View;

class AppView extends View {

    public function initialize() {
        $this->loadHelper('Ittvn.Layout');
    }

}
