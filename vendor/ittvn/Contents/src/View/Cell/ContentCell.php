<?php

namespace Contents\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;
/**
 * Content cell
 */
class ContentCell extends Cell {

    public $helpers = [
        'Ittvn.Layout'
    ];

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($params = [], $form = true) {
        $this->loadModel('Metas.MetaTypes');
        $this->loadModel('Metas.MetaCategories');

        $this->loadModel('Contents.Contents');
        $this->loadModel('Contents.Categories');
        $this->loadModel('Contents.CategoryContents');
        $languages = TableRegistry::get('Extensions.Languages')->find('list', ['keyField' => 'code', 'valueField' => 'name'])->find('network')->where(['status' => 1]);
        if ($form == false) {
            $content_ids = [];
            $flag = false;
            $contents = $this->Contents->find()->find('network');
            $contents->select([
                'Contents.id', 'Contents.name', 'Contents.slug', 'Contents.excerpt', 'Contents.description', 'Contents.image',
                'Contents.hits', 'Contents.featured', 'Contents.created'
            ]);

            if (!empty($params['category'])) {
                $flag = true;
                $categoryContents = $this->CategoryContents->find('list', ['keyField' => 'content_id', 'valueField' => 'content_id'])
                        ->find('network')
                        ->where(['CategoryContents.category_id' => $params['category']]);

                if ($categoryContents->count() > 0) {
                    $contents->contain(['Categories' => function($q) {
                            return $q->select(['Categories.id', 'Categories.name', 'Categories.slug', 'Categories.description'])->where(['Categories.delete' => 0]);
                        }]);
                    $content_ids = $categoryContents->toArray();
                }
            }

            if (count($content_ids) > 0) {
                $contents->where(['Contents.id IN' => $content_ids]);
            } else {
                if ($flag == true) {
                    $contents->where(['Contents.id' => 0]);
                }
            }

            if (!empty($params['meta_type'])) {
                $contents->where(['Contents.meta_type_id' => $params['meta_type']]);
            }

            if (!empty($params['limit'])) {
                $contents->limit($params['limit']);
            }

            $contents->andWhere(['Contents.delete' => 0, 'Contents.status' => 1])->orderDesc('Contents.id');

            $this->loadModel('Contents.ContentMetas');
            $ContentMetas = $this->ContentMetas;
            $contents->formatResults(function($result) use($ContentMetas) {
                return $result->map(function($row) use($ContentMetas) {
                            $content_metas = $ContentMetas->find()
                                    ->find('network')
                                    ->select(['id', 'key', 'value', 'content_id'])
                                    ->where(['ContentMetas.content_id' => $row->id]);
                            if ($content_metas->count() > 0) {
                                $row['content_metas'] = $content_metas->toArray();
                            } else {
                                $row['content_metas'] = [];
                            }
                            return $row;
                        });
            });

            //pr($contents->toArray());
            $this->set('contents', $contents);

            if (!empty($params['meta_type'])) {
                $metaType = $this->MetaTypes->find()
                        ->select(['id', 'name', 'slug'])
                        ->find('network')
                        ->where(['MetaTypes.id' => $params['meta_type'], 'delete' => 0])
                        ->first();

                $this->set('metaType', $metaType);
            }

            if (isset($metaType) && !empty($metaType)) {
                $metaCategories = $this->MetaCategories->find('list', ['keyField' => 'id', 'valueField' => 'id'])->find('network')->where(['meta_type_id' => $metaType->id]);

                $this->set('metaCategories', $metaCategories);
            }

            if (isset($metaCategories) && $metaCategories->count() > 0) {
                $categories = $this->Categories->find()->find('network')
                        ->contain(['MetaCategories' => function($q) {
                                return $q->select(['id', 'name', 'slug']);
                            }])
                        ->select(['id', 'name', 'slug', 'description'])
                        ->where(['meta_category_id IN' => $metaCategories->toArray()]);

                $this->set('categories', $categories);
            }
        } else {
            $metaTypes = $this->MetaTypes->find('list')
                    ->find('network')
                    ->where(['model' => 'Contents', 'delete' => 0]);

            if (isset($params['meta_type']) && !empty($params['meta_type'])) {
                $select_metaType_id = $params['meta_type'];
            } else {
                $select_metaType_id = array_keys($metaTypes->toArray())[0];
            }

            $metaCategories = $this->MetaCategories->find('list')
                    ->find('network')
                    ->where(['MetaCategories.meta_type_id' => $select_metaType_id, 'delete' => 0]);

            if ($metaCategories->count() > 0) {
                if (isset($params['meta_category']) && !empty($params['meta_category'])) {
                    $select_metaCategory_id = $params['meta_category'];
                } else {
                    $select_metaCategory_id = array_keys($metaCategories->toArray())[0];
                }

                $categories = $this->Categories->find('list')
                        ->find('network')
                        ->where(['Categories.meta_category_id' => $select_metaCategory_id, 'Categories.delete' => 0]);
                $categoryContents = $this->CategoryContents->find('list', ['keyField' => 'CategoryContents.content_id', 'valueField' => 'CategoryContents.content_id'])->find('network');
                $select_category_id = [];
                if ($categories->count() > 0) {
                    if (isset($params['category']) && !empty($params['category'])) {
                        $select_category_id = $params['category'];
                    } else {
                        $select_category_id = array_keys($categories->toArray())[0];
                    }

                    $categoryContents->where(['CategoryContents.category_id' => $select_category_id]);
                } else {
                    $categoryContents->where(['CategoryContents.category_id' => 0]);
                }

                $contents = $this->Contents->find('list')
                        ->find('network');
                if ($categoryContents->count() > 0) {
                    $contents->where(['Contents.id IN' => $categoryContents->toArray(), 'Contents.meta_type_id' => $select_metaType_id, 'Contents.delete' => 0]);
                } else {
                    $contents->where(['Contents.id' => 0, 'Contents.meta_type_id' => $select_metaType_id, 'Contents.delete' => 0]);
                }

                $this->set('categories', $categories);
                $this->set('select_category_id', $select_category_id);
                $this->set('select_metaCategory_id', $select_metaCategory_id);
            } else {
                $contents = $this->Contents->find('list')
                        ->find('network')
                        ->where(['Contents.meta_type_id' => $metaType_id, 'Contents.delete' => 0]);
            }
            //pr($languages->toArray()); die();
            $this->set('languages',$languages);
            $this->set('contents', $contents);
            $this->set('metaTypes', $metaTypes);
            $this->set('metaCategories', $metaCategories);
        }
        $this->set('data', $params);
    }

    public function recent($limit = 3, $posttype = 1) {
        $this->loadModel('Contents.Contents');
        
        $contents = $this->Contents->find()->find('network')
                ->select(['Contents.id', 'Contents.name', 'Contents.slug', 'Contents.hits'])
                ->where(['Contents.meta_type_id' => $posttype, 'Contents.delete' => 0, 'Contents.status' => 1])
                ->orderDesc('Contents.id')
                ->limit($limit);
        
        $this->set('contents', $contents);
    }

    public function related($categories = []) {
        if (count($categories) > 0) {
            $this->loadModel('Contents.Contents');
            $this->loadModel('Contents.CategoryContents');
            $categoryContents = $this->CategoryContents->find('list', ['keyField' => 'id', 'valueField' => 'content_id'])
                    ->where(['CategoryContents.category_id IN' => $categories]);

            $contents = $this->Contents->find()
                    ->select(['Contents.id', 'Contents.slug', 'Contents.name', 'Contents.image', 'Contents.excerpt', 'Contents.created'])
                    ->contain([
                        'ContentMetas' => function($q) {
                            return $q->select(['id', 'key', 'value', 'content_id']);
                        }])
                    ->where(['Contents.id IN' => $categoryContents->toArray(), 'Contents.delete' => 0]);

            $this->set('contents', $contents);
        }
    }

    public function counter() {
        $this->loadModel('Metas.MetaTypes');
        $metatypes = $this->MetaTypes->find()
                        ->select(['MetaTypes.id', 'MetaTypes.name', 'MetaTypes.slug', 'MetaTypes.icon'])
                        ->contain([
                            'Contents' => function($q) {
                                return $q->select(['id', 'meta_type_id']);
                            }
                        ])->where(['MetaTypes.model' => 'Contents', 'delete' => 0]);
        $this->set('metatypes', $metatypes);
    }

}
