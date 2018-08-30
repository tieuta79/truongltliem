<?php

namespace Contents\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Contents\Model\Entity\ContentMeta;
use Cake\Core\Configure;
/**
 * ContentMetas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Contents
 * @property \Cake\ORM\Association\HasMany $Contents
 */
class ContentMetasTable extends AppTable {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('content_metas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Contents', [
            'foreignKey' => 'content_id',
            'className' => 'Contents.Contents'
        ]);
        $this->hasMany('Contents', [
            'foreignKey' => 'content_meta_id',
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
                ->requirePresence('key', 'create')
                ->notEmpty('key');

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
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['content_id'], 'Contents'));
        return $rules;
    }

}
