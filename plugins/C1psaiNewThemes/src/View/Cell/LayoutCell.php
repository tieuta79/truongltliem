<?php
namespace NewThemes\View\Cell;

use Cake\View\Cell;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Plugin;

/**
 * Layout cell
 */
class LayoutCell extends Cell
{

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
    public function display($slug = null)
    {
        $this->loadModel('Contents.Categories');
        $category = $this->Categories->find('list', ['keyField' => 'id', 'valueField' => 'id'])
                ->where(['Categories.slug' => $slug]);

        $this->loadModel('Contents.CategoryContents');
        $contentsIds = $this->CategoryContents->find('list', ['keyField' => 'id', 'valueField' => 'content_id'])
                ->where(['category_id IN' => $category->toArray()]);

        $this->loadModel('Contents.Contents');
        $contents = $this->Contents->find()
                ->select(['Contents.id', 'Contents.name', 'Contents.slug', 'Contents.description' , 'Contents.image', 'Contents.modified'])
                ->contain(['MetaTypes' => function($q) {
                        return $q->select(['id', 'name', 'slug','description']);
                    }])
                ->where(['Contents.id IN' => $contentsIds->toArray()]);

        $this->set('contents', $contents);
    }
    
    public function document_page($slug = null){
        $this->loadModel('Contents.Categories');
        $category = $this->Categories->find('list', ['keyField' => 'id', 'valueField' => 'id'])
                ->where(['Categories.slug' => $slug]);

        $this->loadModel('Contents.CategoryContents');
        $contentsIds = $this->CategoryContents->find('list', ['keyField' => 'id', 'valueField' => 'content_id'])
                ->where(['category_id IN' => $category->toArray()]);

        $this->loadModel('Contents.Contents');
        $contents = $this->Contents->find()
                ->select(['Contents.id', 'Contents.name', 'Contents.slug', 'Contents.description' , 'Contents.image', 'Contents.modified'])
                ->contain(['MetaTypes' => function($q) {
                        return $q->select(['id', 'name', 'slug','description']);
                    }])
                ->where(['Contents.id IN' => $contentsIds->toArray()]);

        $this->set('contents', $contents);
    }
}
