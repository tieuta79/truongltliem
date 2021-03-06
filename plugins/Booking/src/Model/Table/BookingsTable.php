<?php

namespace Booking\Model\Table;

use Booking\Model\Entity\Booking;
use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * Bookings Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Contents
 */
class BookingsTable extends AppTable {

    public $filterTable = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('bookings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');

        $this->belongsTo('Contents', [
            'foreignKey' => 'content_id',
            'className' => 'Contents.Contents'
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
                ->allowEmpty('last_name');

        $validator
                ->add('email', 'valid', ['rule' => 'email'])
                ->allowEmpty('email');

        $validator
                ->allowEmpty('phone');

        $validator
                ->add('adults', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('adults');

        $validator
                ->add('children', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('children');

        $validator
                ->add('checkin', 'valid', ['rule' => 'date'])
                ->allowEmpty('checkin');

        $validator
                ->add('checkout', 'valid', ['rule' => 'date'])
                ->allowEmpty('checkout');

        $validator
                ->add('status', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('status');

        $validator
                ->add('delete', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('delete');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['content_id'], 'Contents'));
        return $rules;
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

}
