<?php

namespace Products\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;

/**
 * Products cell
 */
class ProductsCell extends Cell {

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

    public function featured($params = [], $form = true) {
        if ($form == false) {
            $this->loadModel('Contents.Contents');
            $products = $this->Contents->find()
                    ->contain(['MetaTypes'])
                    ->where(['Contents.featured' => 1, 'Contents.delete' => 0, 'MetaTypes.slug' => 'products']);
            $this->set('products', $products);
        }
        $this->set('data', $params);
    }

    public function medias($galleries = []) {
        if (is_string($galleries)) {
            if (strpos($galleries, ',') == true) {
                $galleries = explode(',', $galleries);
            } else {
                $galleries = [$galleries];
            }
        }
        $this->loadModel('Medias.Medias');
        $medias = $this->Medias->find()
                ->select(['id', 'url'])
                ->where(['id IN' => $galleries]);

        $this->set('medias', $medias);
    }

    public function attributes($product_id = null) {
        $this->loadModel('Products.Attributes');
        $attributes = $this->Attributes->find()
                ->select(['id', 'name', 'type', 'options'])
                ->contain(['AttributeProducts' => function($q) use($product_id) {
                return $q->select(['id', 'content_id', 'attribute_id', 'value'])->where(['content_id' => $product_id]);
            }]);
    }

    public function related($categories = []) {
        if (count($categories) > 0) {
            $this->loadModel('Contents.Contents');
            $this->loadModel('Contents.CategoryContents');
            $categoryContents = $this->CategoryContents->find('list', ['keyField' => 'id', 'valueField' => 'content_id'])
                    ->where(['CategoryContents.category_id IN' => $categories]);

            $products = $this->Contents->find()
                    ->select(['Contents.id', 'Contents.slug', 'Contents.name', 'Contents.image', 'Contents.excerpt'])
                    ->contain([
                        'ContentMetas' => function($q) {
                            return $q->select(['id', 'key', 'value', 'content_id']);
                        }])
                    ->where(['Contents.id IN' => $categoryContents->toArray(), 'Contents.delete' => 0]);

            $this->set('products', $products);
        }
    }

    public function viewed($slug = null) {
        $slugs = [];
        if ($this->request->session()->check('Content.viewed.products')) {
            $slugs = $this->request->session()->read('Content.viewed.products');
        }

        $this->request->session()->write('Content.viewed.products', Hash::merge($slugs, [$slug]));
        if (count($slugs) > 0) {
            $this->loadModel('Contents.Contents');
            $products = $this->Contents->find()
                    ->select(['Contents.id', 'Contents.slug', 'Contents.name', 'Contents.image', 'Contents.excerpt'])
                    ->contain([
                        'ContentMetas' => function($q) {
                            return $q->select(['id', 'key', 'value', 'content_id']);
                        }])
                    ->where(['Contents.slug IN' => $slugs, 'Contents.delete' => 0]);

            $this->set('products', $products);
        }
    }

    public function cross($ids = []) {
        if (is_string($ids)) {
            if (strpos($ids, ',') == true) {
                $ids = json_decode($ids, true);
            } else {
                $ids = [$ids];
            }
        }

        $this->loadModel('Contents.Contents');
        $products = $this->Contents->find()
                ->select(['Contents.id', 'Contents.slug', 'Contents.name', 'Contents.image', 'Contents.excerpt'])
                ->contain([
                    'ContentMetas' => function($q) {
                        return $q->select(['id', 'key', 'value', 'content_id']);
                    }])
                ->where(['Contents.id IN' => $ids, 'Contents.delete' => 0]);

        $this->set('products', $products);
    }

    public function filters($categories = []) {
        $this->loadModel('Products.Attributes');
        $attributes = $this->Attributes->find()->select(['id', 'name', 'type', 'options'])->where(['status' => 1, 'delete' => 0]);
        $this->set('attributes', $attributes);
    }

}
