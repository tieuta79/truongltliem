<?php

namespace Sites\Routing\Route;

use Cake\Routing\Route\InflectedRoute as CakeInflectedRoute;
use Sites\Routing\PrefixedRouteTrait;

class NetworkRoute extends CakeInflectedRoute {

    use PrefixedRouteTrait;
}