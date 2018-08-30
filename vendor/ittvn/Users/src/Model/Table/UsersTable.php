<?php

namespace Users\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Users\Model\Entity\User;
use Search\Manager;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Ittvn\Utility\Upload;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Ittvn\Utility\Network;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Hash;
use Settings\Utility\Setting;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\HasMany $UserMetas
 */
class UsersTable extends AppTable {

    public $filterTable = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('full_name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Acl.Acl', ['type' => 'requester']);
        $this->addBehavior('Search.Search');
        $this->addBehavior('Ittvn.Files', [
            'fields' => ['avatar']
        ]);
        $this->addBehavior('Metas.Metas', [
            'modelMeta' => 'UserMetas',
            'foreign_key' => 'user_id'
        ]);

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
            'className' => 'Users.Roles'
        ]);
        $this->hasMany('UserMetas', [
            'foreignKey' => 'user_id',
            'className' => 'Users.UserMetas'
        ]);

        $this->belongsToMany('Messages', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'message_id',
            'joinTable' => 'messages_users',
            'className' => 'Users.Messages'
        ]);

        $this->hasMany('Logs', [
            'foreignKey' => 'user_id',
            'className' => 'Users.Logs'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');

        $validator
                ->allowEmpty('first_name');

        $validator
                ->allowEmpty('middle_name');

        $validator
                ->allowEmpty('last_name');

        $validator
                ->requirePresence('username', 'create')
                ->notEmpty('username');

        $validator
                ->requirePresence('password', 'create')
                ->notEmpty('password');
        $validator
                ->requirePresence('password_confirm', 'create')
                ->notEmpty('password_confirm')
                ->add('password_confirm', [
                    'compare' => [
                        'rule' => ['compareWith', 'password']
                    ]
        ]);
        $validator
                ->add('email', 'valid', ['rule' => 'email'])
                ->allowEmpty('email');

        $validator
                ->allowEmpty('avatar');

        $validator
                ->allowEmpty('sex');

        $validator
                ->allowEmpty('birthday');

        $validator
                ->allowEmpty('phone');

        $validator
                ->allowEmpty('public_key');

        $validator
                ->allowEmpty('private_key');

        $validator
                ->allowEmpty('active_code');

        $validator
                ->add('status', 'valid', ['rule' => 'boolean'])
                ->requirePresence('status', 'create')
                ->notEmpty('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        }

        if (isset($data['password_old']) && empty($data['password_old'])) {
            unset($data['password_old']);
        }

        if (isset($data['password_confirm']) && empty($data['password_confirm'])) {
            unset($data['password_confirm']);
        }

        if (isset($data['birthday'])) {
            if (is_string($data['birthday'])) {
                $data['birthday'] = date('Y-m-d', strtotime($data['birthday']));
            }
        }
    }

    // Configure how you want the search plugin to work with this table class
    public function searchConfiguration() {
        $search = new Manager($this);

        $fields = Configure::read('Admin.Tables.' . $this->alias() . '.header');
        $listFields = [];
        foreach ($fields as $field => $value) {
            if (isset($value['filter']) && $value['filter'] == 'text') {
                if ($this->aliasField($field)) {
                    $search->like($field, [
                        'before' => true,
                        'after' => true,
                        'field' => $this->aliasField($field)
                    ]);

                    $listFields[] = $this->aliasField($field);
                }
            } else if (isset($value['filter']) && $value['filter'] == 'list') {
                if ($this->aliasField($field)) {
                    $search->value($field, [
                        'field' => $this->aliasField($field),
                        'filterEmpty' => true
                    ]);
                }
            }
        }

        if (count($listFields) > 0) {
            $search->like('q', [
                'before' => true,
                'after' => true,
                'field' => $listFields
            ]);
        }

        if ($this->aliasField('delete')) {
            $search->value('trash', [
                'field' => $this->aliasField('delete')
            ]);
        }

        return $search;
    }

    public function findAuthDomain(Query $query, array $options) {
        $request = Router::getRequest();
        if (Configure::check('Network')) {
            if ($request->host() != Configure::read('Network.mainDomain')) {
                $query->find('network');
                if ($query->count() == 0) {
                    $setting = new Setting();
                    $query->find('network', ['site' => 'default'])->andWhere(['Roles.slug' => $setting->getOption('Users.role_default_register')]);
                }
            }
        }
        return $query;
    }

}
