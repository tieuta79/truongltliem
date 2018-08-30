<?php
/**
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Acl\Auth;

use Cake\Network\Request;
use Ittvn\Utility\User;
use Cake\Routing\Router;
use Settings\Utility\Setting;
/**
 * An authorization adapter for AuthComponent. Provides the ability to authorize using the AclComponent,
 * If AclComponent is not already loaded it will be loaded using the Controller's ComponentRegistry.
 *
 * @see AuthComponent::$authenticate
 * @see AclComponent::check()
 */
class ActionsAuthorize extends BaseAuthorize
{

    /**
     * Authorize a user using the AclComponent.
     *
     * @param array $user The user to authorize
     * @param \Cake\Network\Request $request The request needing authorization.
     * @return bool
     */
    public function authorize($user, Request $request)
    {
        $user = User::get();
        if(!$user){
            return false;
        }        
        $setting = new Setting();
        $request = Router::getRequest();
        if ($request->prefix == 'admin') {
            if(!User::checkLoginMainDomain() || $user['role']['slug'] == $setting->getOption('Users.fullPermission')){
                return true;
            }            
        }        
        
        $Acl = $this->_registry->load('Acl');
        $user = [$this->_config['userModel'] => $user];      
        return $Acl->check($user, $this->action($request));
    }
}
