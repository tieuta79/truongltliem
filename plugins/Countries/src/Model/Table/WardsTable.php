<?php
namespace Countries\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Countries\Model\Entity\Ward;
use Search\Manager;

/**
 * Wards Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Countries
 * @property \Cake\ORM\Association\BelongsTo $Provinces
 * @property \Cake\ORM\Association\BelongsTo $Cities
 * @property \Cake\ORM\Association\HasMany $Addresses
 */
class WardsTable extends Table
{

    public $filterTable = true;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('wards');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Ittvn.Sluggable');

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'className' => 'Countries'
        ]);
        $this->belongsTo('Provinces', [
            'foreignKey' => 'province_id',
            'className' => 'Provinces'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'className' => 'Cities'
        ]);
        $this->hasMany('Addresses', [
            'foreignKey' => 'ward_id',
            'className' => 'Countries.Addresses'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('name');

        $validator
            ->allowEmpty('slug');

        $validator
            ->add('delete', 'valid', ['rule' => 'boolean'])
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
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['province_id'], 'Provinces'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
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
