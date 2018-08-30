<?php
namespace Products\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Products\Model\Entity\AttributeProduct;

/**
 * AttributeProducts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Contents
 * @property \Cake\ORM\Association\BelongsTo $Attributes
 */
class AttributeProductsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('attribute_products');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Contents', [
            'foreignKey' => 'content_id',
            'className' => 'Products.Contents'
        ]);
        $this->belongsTo('Attributes', [
            'foreignKey' => 'attribute_id',
            'className' => 'Products.Attributes'
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
            ->allowEmpty('value');

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
        $rules->add($rules->existsIn(['content_id'], 'Contents'));
        $rules->add($rules->existsIn(['attribute_id'], 'Attributes'));
        return $rules;
    }
}
