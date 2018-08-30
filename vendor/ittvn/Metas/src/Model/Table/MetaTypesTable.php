<?php

namespace Metas\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Metas\Model\Entity\MetaType;
use Cake\Event\Event;
use Search\Manager;
use Cake\Core\Configure;
use ArrayObject;

/**
 * MetaTypes Model
 *
 */
class MetaTypesTable extends AppTable {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('meta_types');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Ittvn.Sluggable');
        $this->addBehavior('Search.Search');

        $this->hasMany('Contents', [
            'foreignKey' => 'meta_type_id',
            'className' => 'Contents.Contents'
        ]);

        $this->hasMany('MetaCategories', [
            'foreignKey' => 'meta_type_id',
            'className' => 'Metas.MetaCategories'
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
                ->allowEmpty('model');

        $validator
                ->add('menu', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('menu');

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if (isset($data['options']) && !empty($data['options']) && is_array($data['options'])) {
            $data['options'] = json_encode($data['options']);
        }else{
            $data['options'] = json_encode([]);
        }
    }

    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary) {
        if ($query->count() > 0) {
            $query->formatResults(function ($results) {
                return $results->map(function ($row) {
                            if (isset($row->options) && !empty($row->options)) {
                                $row->options = json_decode($row->options, true);
                            }
                            return $row;
                        });
            });
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
