<?php
namespace Contents\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $parent_id
 * @property \Contents\Model\Entity\ParentCategory $parent_category
 * @property int $lft
 * @property int $rght
 * @property int $meta_category_id
 * @property \Contents\Model\Entity\MetaCategory $meta_category
 * @property int $category_meta_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Contents\Model\Entity\CategoryMeta[] $category_metas
 * @property \Contents\Model\Entity\ChildCategory[] $child_categories
 * @property \Contents\Model\Entity\CategoryContent[] $category_contents
 */
class Category extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
