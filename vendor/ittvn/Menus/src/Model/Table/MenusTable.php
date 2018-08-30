<?php

namespace Menus\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Menus\Model\Entity\Menu;
use Ittvn\Utility\Language;

/**
 * Menus Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Association\BelongsTo $Contents
 * @property \Cake\ORM\Association\BelongsTo $Menutypes
 */
class MenusTable extends AppTable {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('menus');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');
        $this->addBehavior('Ittvn.Sluggable');

        if (Language::getLanguages()->count() > 1) {
            $this->addBehavior('Translate', [
                'fields' => ['name']
            ]);
        }

        $this->belongsTo('ParentMenus', [
            'className' => 'Menus.Menus',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'className' => 'Menus.Categories'
        ]);
        $this->belongsTo('Contents', [
            'foreignKey' => 'content_id',
            'className' => 'Menus.Contents'
        ]);
        $this->belongsTo('Menutypes', [
            'foreignKey' => 'menutype_id',
            'className' => 'Menus.Menutypes'
        ]);
        $this->hasMany('ChildMenus', [
            'className' => 'Menus.Menus',
            'foreignKey' => 'parent_id'
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
                ->allowEmpty('slug');

        $validator
                ->allowEmpty('description');

        $validator
                ->allowEmpty('image');

        $validator
                ->allowEmpty('url');

        $validator
                ->allowEmpty('is_mega');
        $validator
                ->allowEmpty('is_dropdown');
        $validator
                ->allowEmpty('attributes');

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
        //$rules->add($rules->existsIn(['category_id'], 'Categories'));
        //$rules->add($rules->existsIn(['content_id'], 'Contents'));
        //$rules->add($rules->existsIn(['menutype_id'], 'Menutypes'));
        //$rules->add($rules->existsIn(['parent_id'], 'ParentMenus'));
        return $rules;
    }

}
