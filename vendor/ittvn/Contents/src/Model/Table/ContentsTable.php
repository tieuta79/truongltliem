<?php

namespace Contents\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Contents\Model\Entity\Content;
use Cake\Event\Event;
use Cake\Event\EventManager;
use ArrayObject;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Search\Manager;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Settings\Utility\Setting;
use Ittvn\Utility\Language;
/**
 * Contents Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CategoryContents
 * @property \Cake\ORM\Association\BelongsTo $MetaTypes
 * @property \Cake\ORM\Association\BelongsTo $ContentMetas
 * @property \Cake\ORM\Association\HasMany $ContentMetas
 */
class ContentsTable extends AppTable {

    public $filterTable = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('contents');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Ittvn.Sluggable');
        $this->addBehavior('Search.Search');

        $this->addBehavior('Metas.Metas', [
            'modelMeta' => 'ContentMetas',
            'foreign_key' => 'content_id'
        ]);
		
        if(Language::getLanguages()->count() > 1){
            $setting = new Setting();
            $field = json_decode($setting->getOption('Translation.Contents'),true);
            if(!empty($field)){
                $this->addBehavior('Translate', [
                    'fields' => $field
                ]);
            }            
        }
        
        $this->belongsToMany('Categories', [
            'through' => 'CategoryContents',
            'dependent' => true,
        ]);
        $this->belongsTo('MetaTypes', [
            'foreignKey' => 'meta_type_id',
            'className' => 'Contents.MetaTypes'
        ]);
        $this->hasMany('ContentMetas', [
            'foreignKey' => 'content_id',
            'className' => 'Contents.ContentMetas'
        ]);

        $this->eventManager()->dispatch(new Event('Table.Contents', $this));
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
                ->allowEmpty('excerpt');

        $validator
                ->allowEmpty('description');

        $validator
                ->allowEmpty('image');

        $validator
                ->add('featured', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('featured');

        $validator
                ->add('status', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('status');

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
        //$rules->add($rules->existsIn(['meta_type_id'], 'MetaTypes'));
        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        $request = Router::getRequest();
        if ($request->action == 'add') {
            $metaType = TableRegistry::get('Metas.MetaTypes')->find()
                    ->find('network')
                    ->select(['id'])
                    ->where(['slug' => $request->params['pass'][0]])
                    ->first();
        } else if ($request->action == 'edit') {
            $metaType = TableRegistry::get('Metas.MetaTypes')->find()
                    ->find('network')
                    ->select(['id'])
                    ->where(['slug' => $request->params['pass'][1]])
                    ->first();
        }
		
		if(isset($metaType)){
			$metaCategories = TableRegistry::get('Metas.MetaCategories')->findByMetaTypeId($metaType->id)->find('network')->select(['id', 'name', 'slug']);

			$categories = [];
			foreach ($metaCategories as $metaCategory) {
				$metaCatVariable = Inflector::variable($metaCategory->name);
				if (isset($data[$metaCatVariable]['id']) && !empty($data[$metaCatVariable]['id']) && count($data[$metaCatVariable]['id']) > 0) {
					foreach ($data[$metaCatVariable]['id'] as $id) {
						$categories[]['id'] = $id;
					}
				}
				unset($data[$metaCatVariable]);
			}

			if (count($categories) > 0) {
				$data['categories'] = $categories;
			} else {
				//if(isset($data['categories']) && is_string($data['categories']) && $data['categories']=='id'){
				$data['categories'] = [];
				//}
			}
	//pr($data);die();
			//add event beforeMarshal for Table Contents
			//$result = $this->eventManager()->dispatch(new Event('Table.Contents.beforeMarshal',  $data));
			//if(!empty($result->result)){
			//    $data = $result->result;
			//}
		}
    }

    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary) {
        $request = Router::getRequest();
        if ($request->controler == 'Contents' && $request->action == 'add') {
            $metaType = TableRegistry::get('Metas.MetaTypes')->find()->find('network')->where(['slug' => $request->params['pass'][0]])->first();
        } else if ($request->controler == 'Contents' && $request->action == 'edit') {
            $metaType = TableRegistry::get('Metas.MetaTypes')->find()->find('network')->where(['slug' => $request->params['pass'][1]])->first();
        }

        if (isset($metaType)) {
            $metaCategories = TableRegistry::get('Metas.MetaCategories')->findByMetaTypeId($metaType->id)->find('network')->select(['id', 'name', 'slug']);
            $list_cat = [];
            foreach ($metaCategories as $metaCategory) {
                $metaCatVariable = Inflector::variable($metaCategory->name);
                $list_cat[$metaCategory->id] = $metaCatVariable;
            }

            if ($query->count() > 0) {
                $query->formatResults(function ($results) use($list_cat) {
                    return $results->map(function ($row) use($list_cat) {
                                if (isset($row->categories) && count($row->categories) > 0) {
                                    $tmp = [];
                                    foreach ($row->categories as $k => $v) {
                                        $tmp[$list_cat[$v->meta_category_id]]['id'][] = $v->id;
                                    }

                                    foreach ($tmp as $k => $t) {
                                        $row[$k] = $t;
                                    }
                                }
                                return $row;
                            });
                });
                //pr($query->toArray());die();
            }
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

    public function getList($params = null) {
        $field = 'pages';
        if (isset($params[0])) {
            $field = $params[0];
        }
        $pages = $this->find('list', ['keyField' => 'slug', 'valueField' => 'name'])
                ->contain(['MetaTypes' => function($q) use($field) {
                        return $q->where(['MetaTypes.slug' => $field]);
                    }])
                ->find('Network')
                ->where([$this->aliasField('status') => 1, $this->aliasField('delete') => 0]);
                    
        $list[] = __d('ittvn','Default link');
        if ($pages->count() > 0) {
            return Hash::merge($list, $pages->toArray());
        }
        return $list;
    }

}
