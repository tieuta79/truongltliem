<?php
namespace Products\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Products\Model\Entity\Payment;
use Search\Manager;
use Cake\Event\Event;
use ArrayObject;
/**
 * Payments Model
 *
 * @property \Cake\ORM\Association\HasMany $Orders
 */
class PaymentsTable extends Table
{

    public $filterTable = true;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('payments');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');

        $this->hasMany('Orders', [
            'foreignKey' => 'payment_id',
            'className' => 'Products.Orders'
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
            ->allowEmpty('name');

        $validator
            ->add('fee', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fee');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('options');

        return $validator;
    }
    
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if (isset($data['options']) && is_array($data['options'])) {
            $data['options'] = json_encode($data['options']);
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
