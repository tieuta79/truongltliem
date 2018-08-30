<?php

namespace Ittvn\Utility;

use InvalidArgumentException;
use RuntimeException;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Migrations\Migrations;
use Cake\Core\Plugin;
use Ittvn\Utility\System;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class InstallDb {

    public function __construct() {

        $this->request = Router::getRequest();
    }

    public function createDb($dbName, $prefix = true) {
        if ($prefix == true) {
            $db = ConnectionManager::get('default');
            $db->execute('CREATE DATABASE IF NOT EXISTS ' . $db->config()['database'] . '_' . $dbName);
            return $db->config()['database'] . '_' . $dbName;
        }
    }
    
    public function dropDb($dbName, $prefix = true) {
        if ($prefix == true) {
            $db = ConnectionManager::get('default');
            $db->execute('DROP DATABASE IF EXISTS ' . $db->config()['database'] . '_' . $dbName);
        }
    }

    public function createTables($dbName) {
        $configDefault = ConnectionManager::get('default')->config();

        $siteDb = $configDefault['database'] . '_' . $dbName;
        ConnectionManager::config($siteDb, [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => $configDefault['persistent'],
            'host' => $configDefault['host'],
            'username' => $configDefault['username'],
            'password' => $configDefault['password'],
            'database' => $siteDb,
            'encoding' => $configDefault['encoding'],
            'timezone' => $configDefault['timezone'],
            'cacheMetadata' => $configDefault['cacheMetadata'],
            'quoteIdentifiers' => $configDefault['quoteIdentifiers'],
        ]);

        $migrations = new Migrations(['connection' => $siteDb]);

        $system = new System();
        $p = $system->listPlugin();
        $plugins = array_keys($p['active']);

        $plugin_path = ROOT . DS . 'vendor' . DS . 'ittvn';
        $dir = new Folder($plugin_path);
        $all_plugins = $dir->read(true, false, false)[0];
        $plugins = Hash::merge($plugins, $all_plugins);

        foreach ($plugins as $plugin) {
            if (in_array($plugin, ['Themes', 'Templates']))
                continue;
            $status = $migrations->status(['plugin' => $plugin]);
            if (count($status) > 0) {
                $migrate = $migrations->migrate(['plugin' => $plugin]);
                $seeded = $migrations->seed(['plugin' => $plugin]);
            }
        }
    }

}
