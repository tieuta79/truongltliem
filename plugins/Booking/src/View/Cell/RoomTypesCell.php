<?php

namespace Booking\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;
use Booking\Form\CheckroomForm;
use Cake\I18n\Time;
/**
 * RoomTypes cell
 */
class RoomTypesCell extends Cell {

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
    public function featured($params = [], $form = true) {
        if ($form == false) {
            $this->loadModel('Contents.Contents');
            $roomtypes = $this->Contents->find()
                    ->find('network')
                    ->select(['id', 'name', 'slug', 'image'])
                    ->contain([
                        'MetaTypes',
                        'ContentMetas' => function($q) {
                            return $q->select(['id', 'key', 'value', 'content_id']);
                        }
                    ])
                    ->where(['Contents.featured' => 1, 'Contents.delete' => 0, 'MetaTypes.slug' => 'roomtypes']);
            //pr($roomtypes->toArray());die();
            $this->set('roomtypes', $roomtypes);
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
                ->find('network')
                ->where(['id IN' => $galleries]);

        $this->set('medias', $medias);
    }

    public function categories($categories = []) {
        if (count($categories) > 0) {
            $categories = Hash::extract($categories, '{n}.id');
            $this->loadModel('Contents.Categories');
            $features = $this->Categories->find()
                    ->find('network')
                    ->select(['Categories.id','Categories.name','Categories.slug'])
                    ->contain(['CategoryMetas' => function($q) {
                            return $q->select(['id', 'key', 'value', 'category_id']);
                        }])
                    ->where(['Categories.id IN' => $categories, 'delete' => 0]);
                        
            $this->set('features', $features);
        }
    }
    
    public function check($content_id = null) {
        $this->request->data['checkin'] = !empty($this->request->data['checkin'])?((new Time($this->request->data['checkin']))->format('Y-m-d')):'';
        $this->request->data['checkout'] = !empty($this->request->data['checkout'])?((new Time($this->request->data['checkout']))->format('Y-m-d')):'';
        $success = false;
        $checkroom = new CheckroomForm();
        if ($this->request->is(['post','put'])) {
            if ($checkroom->execute($this->request->data)) {
                $success = true;
            }
        }
        $this->set('content_id', $content_id);
        $this->set('success', $success);
        $this->set('checkroom', $checkroom);
    }

}
