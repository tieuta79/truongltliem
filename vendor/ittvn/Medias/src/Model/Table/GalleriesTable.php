<?php

namespace Medias\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Medias\Model\Entity\Gallery;
use Cake\Event\Event;

/**
 * Galleries Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentGalleries
 * @property \Cake\ORM\Association\HasMany $ChildGalleries
 * @property \Cake\ORM\Association\HasMany $Medias
 */
class GalleriesTable extends AppTable {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('galleries');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');
        $this->addBehavior('Ittvn.Sluggable');

        $this->belongsTo('ParentGalleries', [
            'className' => 'Medias.Galleries',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildGalleries', [
            'className' => 'Medias.Galleries',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Medias', [
            'foreignKey' => 'gallery_id',
            'className' => 'Medias.Medias'
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
                ->allowEmpty('name');

        $validator
                ->allowEmpty('description');

        $validator
                ->allowEmpty('type');

        $validator
                ->add('status', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('status');

        $validator
                ->add('lft', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('lft');

        $validator
                ->add('rght', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('rght');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentGalleries'));
        return $rules;
    }

}
