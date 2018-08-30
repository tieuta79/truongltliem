<?php

namespace Blocks\Model\Table;

use Blocks\Model\Entity\Block;
use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * Blocks Model
 *
 */
class BlocksTable extends AppTable {

    public $filterTable = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('blocks');
        $this->displayField('name');
        $this->primaryKey('id');
        /*
        $this->addBehavior('Translate', [
            'fields' => 'cells'
        ]);
         * 
         */
        $this->addBehavior('Timestamp');
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

        return $validator;
    }

}
