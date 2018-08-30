<?php

namespace Sites;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Migrations\Migrations;
use Cake\Core\Plugin;
use Cake\Core\Configure;
use Ittvn\Utility\Network;
use Cake\Routing\Router;
use Cake\Utility\Hash;

class Network {

    public static $domains = [];

    public static function configOtherDb() {
        $User = TableRegistry::get('Users.Users');
        $sites = TableRegistry::get('Sites.Sites')->find()
                ->select(['user_id'])
                ->where(['status' => 1, 'delete' => 0])
                ->formatResults(function($result) use($User) {
            return $result->map(function($row) use($User) {
                        $user = $User->find()->select(['username'])->where(['id' => $row->user_id])->first();
                        $row['username'] = $user->username;
                        return $row;
                    });
        });

        if ($sites->count() > 0) {
            $allConfigs = ConnectionManager::configured();
            $configDefault = ConnectionManager::get('default')->config();
            foreach ($sites as $site) {
                $siteDb = $configDefault['database'] . '_' . $site->username;
                if (!in_array($siteDb, $allConfigs)) {
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
                    //Plugin::load('Products', ['bootstrap' => true, 'routes' => true]);
                    //$migrations = new Migrations(['plugin' => 'Products']);
                    //$status = $migrations->status();
                    //pr($status);die();
                    //$migrate = $migrations->migrate();
                    //$seeded = $migrations->seed();
                    //pr($seeded);die();
                    $this->domains[] = $site->username;
                }
            }
        }
    }

    public static function setDbNetwork() {
        $request = Router::getRequest();
        $db = Configure::read('Network.db');
        if (Configure::read('Network.type') == 1) {
            $network = Network::checkScopeByUrl($request->here, $this->domains);
            if ($network) {
                $db = substr($network, 1);
            }
        } else {
            $db = $request->subdomains();
        }
        Configure::write('Network.db', $db);
        Configure::write('Sites.domains', $this->domains);
    }

    public static function getDataMigrations($modal) {
        $M = TableRegistry::get($modal);
        $columns = $M->schema()->columns();
        $columns = Hash::combine($columns, '{n}');
        $columns = Hash::remove($columns, 'id');
        $columns = Hash::remove($columns, 'created');
        $columns = Hash::remove($columns, 'modified');

        $datas = $M->find();
        $string = [];
        foreach ($datas as $i => $data) {
            $arr = array_intersect_key($data->toArray(), $columns);
            foreach ($arr as $k => $val) {
                if (filter_var($val, FILTER_VALIDATE_INT)) {
                    $string[$i][] = "\t'" . $k . "' => " . $val . "";
                } else {
                    $string[$i][] = "\t'" . $k . "' => '" . $val . "'";
                }
            }
            $string[$i] = "[\n" . implode(",\n", $string[$i]) . "\n]";
        }
        pr(implode(",\n", $string));
        die();
    }

}
?>