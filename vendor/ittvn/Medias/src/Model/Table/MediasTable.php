<?php

namespace Medias\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Medias\Model\Entity\Media;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use ArrayObject;
use Ittvn\Utility\Upload;

/**
 * Medias Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Galleries
 */
class MediasTable extends AppTable {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('medias');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Galleries', [
            'foreignKey' => 'gallery_id',
            'className' => 'Medias.Galleries'
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
                ->allowEmpty('url');

        $validator
                ->allowEmpty('type');

        $validator
                ->add('size', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('size');

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
        //$rules->add($rules->existsIn(['gallery_id'], 'Galleries'));
        return $rules;
    }

    public function beforeDelete(Event $event, EntityInterface $entity, ArrayObject $options) {
        if (isset($entity->url) && !empty($entity->url)) {
            $upload = new Upload();
            $upload->delete($entity->url, true);
        }
    }

}
