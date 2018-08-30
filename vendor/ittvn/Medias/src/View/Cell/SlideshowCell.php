<?php

namespace Medias\View\Cell;

use Cake\View\Cell;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Utility\Hash;

/**
 * Slideshow cell
 */
class SlideshowCell extends Cell {

    public $helpers = [
        'Html',
        'Ittvn.Layout'
    ];

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    public function show($params = [], $form = true) {
        $this->loadModel('Medias.Slideshow');
        if ($form == false) {
            $slides = $this->Slideshow->find()
                    ->find('network')
                    ->select(['Slideshow.id', 'Slideshow.name', 'Slideshow.slug', 'Slideshow.type', 'Slideshow.gallery_id', 'Slideshow.category_id', 'Slideshow.content', 'Slideshow.config'])
                    ->contain([
                        'Galleries' => function($q) {
                            return $q->select(['id', 'name', 'slug']);
                        }
                    ])
                    ->where(['Slideshow.slug' => $params['slideshow']]);
            $listimages = [];
            if ($slides->first()->type == 2) {
                $listid = json_decode($slides->first()->content);
                if (count($listid) > 0) {
                    $listimages = $this->listcontent($listid);
                }
                $this->set('medias', $listimages);
            } else if ($slides->first()->type == 1) {
                $this->loadModel('Contents.CategoryContents');
                $categories = $this->CategoryContents->find()->find('network')->where(['category_id' => $slides->first()->category_id]);
                if ($categories->count() > 0) {
                    $listcontentid = Hash::combine($categories->toArray(), '{n}.content_id', '{n}.content_id');
                    $listimages = $this->listcontent($listcontentid);
                }
                $this->set('medias', $listimages);
            } else if ($slides->first()->type == 0) {
                $this->loadModel('Medias.Medias');
                $medias = $this->Medias->find()->find('network')->select(['id', 'url', 'title'])->where(['gallery_id' => $slides->first()->gallery->id]);
                if ($medias->count() > 0) {
                    foreach ($medias as $keym => $media) {
                        $listimages[$keym]['url'] = $media->url;
                        $listimages[$keym]['title'] = $media->title;
                    }
                }
                $this->set('medias', $listimages);
            }

            $config = json_decode($slides->first()->config, true);
            $this->set('config', $config);
        } else {
            $slides = $this->Slideshow->find('list', ['keyField' => 'slug', 'keyValue' => 'name'])->find('network')->where(['status' => 1]);
            $languages = TableRegistry::get('Extensions.Languages')->find('list', ['keyField' => 'code', 'valueField' => 'name'])->find('network')->where(['status' => 1]);
            $this->set('languages', $languages);
        }
        $this->set('slides', $slides);
        $this->set('data', $params);
    }

    public function listcontent($listid = null) {
        $this->loadModel('Contents.Contents');
        $contents = $this->Contents->find()->find('network')
                ->where(['Contents.id IN' => $listid, 'Contents.status' => 1, 'Contents.meta_type_id' => 1]);
        if ($contents->count() > 0) {
            $listimages = [];
            foreach ($contents as $keyc => $content) {
                if (!empty($content->image)) {
                    $listimages[$keyc]['url'] = $content->image;
                    $listimages[$keyc]['title'] = $content->name;
                }
            }
            return $listimages;
        }
        return false;
    }

}
