<?php
namespace Translates\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;
use Translates\Model\Entity\Translate;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Metas\Utility\Metas;
use Cake\Utility\Inflector;

/**
 * Translates Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Languages
 * @property \Cake\ORM\Association\BelongsTo $Locales
 */
class TranslatesTable extends Table
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

        $this->table('translates');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Search.Search');

        $this->belongsTo('Languages', [
            'foreignKey' => 'language_id',
            'className' => 'Languages'
        ]);
        $this->belongsTo('Locales', [
            'foreignKey' => 'locale_id',
            'className' => 'Locales'
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
            ->allowEmpty('msgstr');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['language_id'], 'Languages'));
        $rules->add($rules->existsIn(['locale_id'], 'Locales'));
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
	
    public function getList($params = []) {
		$Mo = TableRegistry::get($params[0]);
		$col = [];
		if($params[0] == 'Metas.Metas'){
			$Cmeta = new Metas();

			$metas = $Mo->find('list',['keyField'=>'name', 'keyValue'=>'name'])
			->where(['status'=>1,'delete'=>0])->toArray();	
			foreach($metas as $meta){
				$c = Inflector::slug($meta,'_') . $Cmeta->prefix;
				$col[$c] = $c;	
			}
		}else{
			$cols = $Mo->schema()->columns();
			foreach($cols as $c){
				if(!in_array($c, ['id','delete','modified','created','status','featured','parent_id','lft','rght','meta_type_id','meta_category_id','hits'])){
					$col[$c] = $c;	
				}
			}
		}
		return $col;
    }
}
