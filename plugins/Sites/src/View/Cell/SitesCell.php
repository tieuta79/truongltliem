<?php

namespace Sites\View\Cell;

use Cake\View\Cell;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Sites\ConfigNetwork;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Ittvn\Utility\User;
use Settings\Utility\Setting;
/**
 * Sites cell
 */
class SitesCell extends Cell {

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display() {
        $configDefault = ConnectionManager::get('default')->config();
        $this->loadModel('Sites.Sites');
        $this->loadModel('Settings.Settings');
        $this->loadModel('Users.Users');
        $Setting = $this->Settings;
        $User = $this->Users;
        $sites = $this->Sites->find()->select(['user_id', 'title'])->where(['status' => 1, 'delete' => 0])
                ->formatResults(function ($results) use($configDefault, $Setting, $User) {
            return $results->map(function ($row) use($configDefault, $Setting, $User) {
                        $user = $User->find()->select(['username'])->where(['id' => $row->user_id])->first();
                        $row['username'] = $user->username;
                        $setting = $Setting->find()
                                ->select(['name', 'value'])
                                ->where(['name' => 'Sites.title'])
                                ->find('network', ['site' => $configDefault['database'] . '_' . $user->username])
                                ->first();
                        $row['title_page'] = $setting->value;
                        return $row;
                    });
        });

        $title = $this->Settings->find()
                        ->select(['name', 'value'])
                        ->where(['name' => 'Sites.title'])
                        ->find('network', ['site' => 'default'])
                        ->first()->value;

        $configNetwork = new ConfigNetwork();
        $scope = $configNetwork->getCurrentScope();
        if (Configure::read('Network.type') == 1) {
            if (!empty($scope)) {
                $scope = Hash::extract($sites->toArray(), '{n}[username=/' . $scope . '/]');
                if (count($scope) > 0) {
                    $scope = $scope[0];
                }
            } else {
                $scope = new \stdClass();
                $scope->title = __d('ittvn', 'Main Site');
                $scope->title_page = $title;
            }
        } else {
            $domainMapping = Configure::read('Network.domainMapping');
            $host = '';
            if (isset($domainMapping[$this->request->domain()])) {
                $host = $domainMapping[$this->request->domain()];
                $this->set('domainMapping', $host);
            } else {
                if ($this->request->subdomains()) {
                    $host = $this->request->subdomains()[0];
                }

                $setting = new Setting();
                if (User::get('role.slug') != $setting->getOption('Users.fullPermission')) {
                    $this->set('domainMapping', $host);
                }
            }

            if (!empty($host)) {
                $scope = Hash::extract($sites->toArray(), '{n}[username=/' . $host . '/]');
                if (count($scope) > 0) {
                    $scope = $scope[0];
                }
            } else {
                $scope = new \stdClass();
                $scope->title = __d('ittvn', 'Main Site');
                $scope->title_page = $title;
            }
        }

        $this->set('scope', $scope);
        $this->set('sites', $sites);
        $this->set('title', $title);
    }

}
