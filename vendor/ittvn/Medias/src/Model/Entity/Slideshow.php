<?php
namespace Medias\Model\Entity;

use Cake\ORM\Entity;
/**
 * Slideshow Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $gallery_id
 * @property \App\Model\Entity\Gallery $gallery
 * @property int $category_id
 * @property \App\Model\Entity\Category $category
 * @property string $content
 * @property string $config
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Slideshow extends Entity
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
