<?php

namespace Ittvn\Utility;

use InvalidArgumentException;
use RuntimeException;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Plugin;
use Cake\Core\App;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Settings\Utility\Setting;
use Acl\AclExtras;

class User {

    public static $roles = null;
    public static $user = null;
    public static $sessionKey = 'Registered';

    static function getSessionKey() {
        $request = Router::getRequest();
        if ($request->prefix == 'admin') {
            self::$sessionKey = 'User';
        }
        return self::$sessionKey;
    }

    static function get($field = null) {
        if (empty(self::$user) || !is_array(self::$user)) {
            $request = Router::getRequest();
            if ($request->session()->check(Configure::read('sessionKey'))) {
                self::$user = $request->session()->read(Configure::read('sessionKey'));
            } else {
                return false;
            }
        }

        $user = Hash::flatten(self::$user);
        if (isset($user[$field])) {
            return $user[$field];
        }
        return self::$user;
    }

    static function checkLoginMainDomain($domain = null) {
        if (empty($domain)) {
            $request = Router::getRequest();
            $domain = $request->host();
        }

        $setting = new Setting();
        if ($domain != Configure::read('Network.mainDomain') && self::get('role.slug') != $setting->getOption('Users.fullPermission')) {
            if(self::get('role.slug') == $setting->getOption('Users.role_default_register')){
                return false;
            }else{
                return false;
            }
        }
        return true;
    }

    static function checkLogin() {
        $request = Router::getRequest();
        if ($request->session()->check(Configure::read('sessionKey'))) {
            self::$user = $request->session()->read(Configure::read('sessionKey'));
            return self::$user;
        }
        return false;
    }

    static function getRoleAdminLogin() {
        if (!empty(self::$roles) && is_array(self::$roles)) {
            return self::$roles;
        }

        $Roles = TableRegistry::get('Users.Roles');
        $roles = $Roles->find('list', ['keyField' => 'id', 'valueField' => 'slug'])->find('network')->where(['Roles.admin_login' => 1, 'Roles.delete' => 0]);
        if ($roles->count() > 0) {
            self::$roles = $roles->toArray();
            return self::$roles;
        }
        return [];
    }

    static function buildPermission($sync = 'sync') {
        self::buildAcl($sync);
    }

    private static function buildAcl($sync = 'sync') {
        $AclExtras = new AclExtras();
        $AclExtras->startup();
        if ($sync == 'sync') {
            $result = $AclExtras->acoSync();
            self::buildAros();
        } else {
            $result = $AclExtras->acoUpdate();
        }
    }

    private static function buildAros() {
        $table_aro = 'aros';

        if (Configure::check('Site.buildPermission')) {
            $connection = ConnectionManager::get(Configure::read('Site.buildPermission'));
        } else {
            $connection = ConnectionManager::get(Configure::read('Network.db'));
        }

        $connection->execute('TRUNCATE TABLE ' . $table_aro)->execute();

        $Aros = TableRegistry::get('Acl.Aros', ['connection' => $connection]);
        $Users = TableRegistry::get('Users.Users');

        $roles = $Users->Roles->find()->select(['Roles.id', 'Roles.slug'])->contain(['Users' => function($q) use($connection) {
                return $q->select(['id', 'username', 'role_id'])->connection($connection);
            }])->connection($connection);

        foreach ($roles as $role) {
            $aro = $Aros->newEntity([
                'parent_id' => null,
                'model' => 'Roles',
                'foreign_key' => $role->id,
                'alias' => $role->slug
            ]);
            if ($Aros->save($aro)) {
                if (count($role->users) > 0) {
                    foreach ($role->users as $user) {
                        $aro_user = $Aros->newEntity([
                            'parent_id' => $aro->id,
                            'model' => 'Users',
                            'foreign_key' => $user->id,
                            'alias' => $user->username
                        ]);
                        $Aros->save($aro_user);
                    }
                }
            }
        }
    }

}
