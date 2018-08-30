<?php

namespace Products\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Products\Model\Entity\Filter;
use Search\Manager;
use Cake\Event\Event;
use ArrayObject;

/**
 * Filters Model
 *
 */
class FiltersTable extends Table {

    public $filterTable = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('filters');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Ittvn.Sluggable');
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
                ->allowEmpty('attributes');

        $validator
                ->add('delete', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('delete');

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if (isset($data['attributes']) && is_array($data['attributes'])) {
            $data['attributes'] = json_encode($data['attributes']);
        }
    }

    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary) {
        if ($query->count() > 0) {
            $query->formatResults(function ($results) {
                return $results->map(function ($row) {
                            if (isset($row->attributes) && count($row->attributes) > 0) {
                                $row['attributes'] = json_decode($row->attributes, true);
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
