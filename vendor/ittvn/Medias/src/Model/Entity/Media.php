<?php
namespace Medias\Model\Entity;

use Cake\ORM\Entity;

/**
 * Media Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property string $type
 * @property int $size
 * @property int $gallery_id
 * @property \Medias\Model\Entity\Gallery $gallery
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Media extends Entity
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
