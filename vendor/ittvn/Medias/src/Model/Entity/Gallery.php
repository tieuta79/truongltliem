<?php
namespace Medias\Model\Entity;

use Cake\ORM\Entity;

/**
 * Gallery Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property bool $status
 * @property int $parent_id
 * @property \Medias\Model\Entity\Gallery $parent_gallery
 * @property int $lft
 * @property int $rght
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Medias\Model\Entity\Gallery[] $child_galleries
 * @property \Medias\Model\Entity\Media[] $medias
 */
class Gallery extends Entity
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
