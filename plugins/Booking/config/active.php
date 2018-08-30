<?php

use Ittvn\ActivePlugin;
use Cake\ORM\TableRegistry;

class Active extends ActivePlugin {

    private $metaType = [
        'name' => 'Room Types',
        'slug' => 'roomtypes',
        'icon' => 'fa fa-building',
        'description' => 'Infomation for post type hotels',
        'model' => 'Contents',
        'category' => 1,
        'multi_category' => 1,
        'menu' => 0,
        'options' => '{"showExcerpt":"1","showDescription":"1","showFeatureImage":"1"}'
    ];
    private $metaCategory = [
        'name' => 'Features',
        'slug' => 'room-feature',
        'description' => '',
        'meta_type_id' => 0
    ];

    public function beforeActive($plugins = []) {
        parent::beforeActive($plugins);

        $this->loadModal('Metas.MetaTypes');
        $metaTypes = $this->MetaTypes->find()->find('network')->where($this->metaType);
        if ($metaTypes->count() == 0) {
            $metaType = $this->MetaTypes->newEntity($this->metaType);
            $this->MetaTypes->saveNetwork($metaType);
        } else {
            $metaType = $metaTypes->first();
        }

        $this->metaCategory['meta_type_id'] = $metaType->id;

        $this->loadModal('Metas.MetaCategories');
        $metaCategories = $this->MetaCategories->find()->find('network')->where($this->metaCategory);
        if ($metaCategories->count() == 0) {
            $metaCategory = $this->MetaCategories->newEntity($this->metaCategory);
            $this->MetaCategories->saveNetwork($metaCategory);
        } else {
            $metaCategory = $metaCategories->first();
        }

        $this->loadModal('Metas.Metas');
        $metas = [
            [
                'model' => 'Metas.MetaCategories',
                'foreign_key' => $metaCategory->id,
                'name' => 'Icon',
                'value' => '',
                'type' => 'text',
                'options' => '',
                'status' => 1
            ],
            [
                'model' => 'Metas.MetaTypes',
                'foreign_key' => $metaType->id,
                'name' => 'Galleries',
                'value' => '',
                'type' => 'select_images',
                'options' => '',
                'status' => 1
            ],
            [
                'model' => 'Metas.MetaTypes',
                'foreign_key' => $metaType->id,
                'name' => 'Rooms',
                'value' => '',
                'type' => 'number',
                'options' => '',
                'status' => 1
            ],
            [
                'model' => 'Metas.MetaTypes',
                'foreign_key' => $metaType->id,
                'name' => 'Price',
                'value' => '',
                'type' => 'number',
                'options' => '',
                'status' => 1
            ]
        ];
        foreach ($metas as $meta) {
            $lmetas = $this->Metas->find()->find('network')->where($meta);
            if ($lmetas->count() == 0) {
                $lmeta = $this->Metas->newEntity($meta);
                $this->Metas->saveNetwork($lmeta);
            }
        }
    }

}
