<?php

namespace Medias\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Medias\Model\Entity\Slideshow;
use Search\Manager;
use Cake\Event\Event;
use ArrayObject;
/**
 * Slideshow Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Galleries
 * @property \Cake\ORM\Association\BelongsTo $Categories
 */
class SlideshowTable extends AppTable {

    public $filterTable = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('slideshow');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Ittvn.Sluggable');

        $this->belongsTo('Galleries', [
            'foreignKey' => 'gallery_id',
            'className' => 'Galleries'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'className' => 'Categories'
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
                ->allowEmpty('type');
        
        $validator
                ->allowEmpty('content');

        $validator
                ->allowEmpty('config');

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
        $rules->add($rules->existsIn(['gallery_id'], 'Galleries'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        return $rules;
    }
    
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if(isset($data['content']) && !empty($data['content'])){
            $data['content'] = json_encode($data['content']);
        }
        
        if(isset($data['config']) && !empty($data['config'])){
            $data['config'] = json_encode($data['config']);
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

}
