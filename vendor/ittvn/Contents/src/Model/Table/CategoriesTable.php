<?php

namespace Contents\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Contents\Model\Entity\Category;
use Cake\Event\Event;
use Search\Manager;
use Cake\Core\Configure;
use Settings\Utility\Setting;
use Ittvn\Utility\Language;

/**
 * Categories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentCategories
 * @property \Cake\ORM\Association\BelongsTo $MetaCategories
 * @property \Cake\ORM\Association\BelongsTo $CategoryMetas
 * @property \Cake\ORM\Association\HasMany $ChildCategories
 * @property \Cake\ORM\Association\HasMany $CategoryContents
 * @property \Cake\ORM\Association\HasMany $CategoryMetas
 */
class CategoriesTable extends AppTable {

    public $filterTable = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('categories');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Ittvn.Sluggable');

        $this->addBehavior('Metas.Metas', [
            'modelMeta' => 'CategoryMetas',
            'foreign_key' => 'category_id'
        ]);
        if(Language::getLanguages()->count() > 1){
            $setting = new Setting();
            $field = json_decode($setting->getOption('Translation.Categories'),true);
            if(!empty($field)){
                $this->addBehavior('Translate', [
                    'fields' => $field
                ]);
            }
        }
        $this->belongsTo('ParentCategories', [
            'className' => 'Contents.Categories',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('MetaCategories', [
            'foreignKey' => 'meta_category_id',
            'className' => 'Contents.MetaCategories'
        ]);
        $this->hasMany('ChildCategories', [
            'className' => 'Contents.Categories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('CategoryContents', [
            'foreignKey' => 'category_id',
            'className' => 'Contents.CategoryContents',
            'dependent' => true
        ]);
        $this->hasMany('CategoryMetas', [
            'foreignKey' => 'category_id',
            'className' => 'Contents.CategoryMetas'
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

        $validator->notEmpty('name');

        $validator
                ->allowEmpty('slug');

        $validator
                ->allowEmpty('description');

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
        //$rules->add($rules->existsIn(['parent_id'], 'ParentCategories'));
        $rules->add($rules->existsIn(['meta_category_id'], 'MetaCategories'));
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
