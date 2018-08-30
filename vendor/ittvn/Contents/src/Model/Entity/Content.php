<?php
namespace Contents\Model\Entity;

use Cake\ORM\Entity;

/**
 * Content Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $excerpt
 * @property string $description
 * @property string $image
 * @property int $category_content_id
 * @property \Contents\Model\Entity\CategoryContent $category_content
 * @property int $meta_type_id
 * @property \Contents\Model\Entity\MetaType $meta_type
 * @property int $content_meta_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Contents\Model\Entity\ContentMeta[] $content_metas
 */
class Content extends Entity
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
