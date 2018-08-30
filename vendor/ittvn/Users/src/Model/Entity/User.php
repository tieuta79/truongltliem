<?php

namespace Users\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity.
 *
 * @property int $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $avatar
 * @property string $phone
 * @property string $public_key
 * @property string $private_key
 * @property string $active_code
 * @property int $role_id
 * @property \Users\Model\Entity\Role $role
 * @property bool $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Users\Model\Entity\UserMeta[] $user_metas
 */
class User extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
    protected $_virtual = ['full_name'];
    protected $_hidden = ['password', 'password_confirm'];

    protected function _setPassword($password) {
        return (new DefaultPasswordHasher)->hash($password);
    }

    protected function _getFullName() {
        if (empty($this->_properties['first_name']) && empty($this->_properties['middle_name']) && empty($this->_properties['last_name'])) {
            $full_name = $this->_properties['username'];
        } else {
            if (!empty($this->_properties['middle_name'])) {
                $full_name = $this->_properties['first_name'] . ' ' . $this->_properties['middle_name'] . ' ' . $this->_properties['last_name'];
            } else {
                $full_name = $this->_properties['first_name'] . ' ' . $this->_properties['last_name'];
            }
        }
        return $full_name;
    }

	public function parentNode()
	{
            if (!$this->id) {
                    return null;
            }
            if (isset($this->role_id)) {
                    $groupId = $this->role_id;
            } else {
                    $Users = TableRegistry::get('Users.Users');
                    $user = $Users->find('all', ['fields' => ['role_id']])->where(['id' => $this->id])->first();
                    $groupId = $user->role_id;
            }
            if (!$groupId) {
                    return null;
            }
            return ['Roles' => ['id' => $groupId]];
	}
	
}
