<?php

namespace Sites\Routing;

use Cake\Network\Request;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

trait PrefixedRouteTrait {

    private $prefixes = [];

    private function checkDomain($host) {
        $parts = explode('.', $host);
        if (count($parts) > 2 && $parts[0] != "www") {
            $subdomain = explode('.', $host, 2);
            if (in_array($subdomain[0], $this->prefixes)) {
                return $subdomain;
            }
            throw new NotFoundException(__d('ittvn','This site not exist.'));
        }

        return [false, $host];
    }

    private function getPrefixAndHost(array $context = []) {
        if (Configure::read('Network.type') == 2) {
            $this->prefixes = Configure::read('Sites.domains');
        }
        if (empty($context['_host'])) {
            $request = Router::getRequest(true) ?: Request::createFromGlobals();
            $host = $request->host();
        } else {
            $host = $context['_host'];
        }

        return $this->checkDomain($host);
    }

    private function checkPrefix($prefix) {
        $routePrefix = isset($this->defaults['prefix']) ? $this->defaults['prefix'] : false;
        return $prefix === $routePrefix;
    }

    public function parse($url, $method = '') {
        list($prefix) = $this->getPrefixAndHost();
        //debug($prefix);die();
        if (!$this->checkPrefix($prefix)) {
            return false;
        }
        return parent::parse($url, $method);
    }

    public function match(array $url, array $context = []) {
        pr($url);die('match');
        if (!isset($url['prefix'])) {
            $url['prefix'] = false;
        }
        if (!$this->checkPrefix($url['prefix'])) {
            return false;
        }
        list($prefix, $host) = $this->getPrefixAndHost($context);
        if ($prefix !== $url['prefix']) {
            $url['_host'] = $url['prefix'] === false ? $host : $url['prefix'] . '.' . $host;
        }
        return parent::match($url, $context);
    }

}
