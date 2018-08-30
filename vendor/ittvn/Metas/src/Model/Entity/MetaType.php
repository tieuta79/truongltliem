<?php
namespace Metas\Model\Entity;

use Cake\ORM\Entity;

/**
 * MetaType Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $model
 * @property bool $menu
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class MetaType extends Entity
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
