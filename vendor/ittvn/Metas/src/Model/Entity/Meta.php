<?php
namespace Metas\Model\Entity;

use Cake\ORM\Entity;

/**
 * Meta Entity.
 *
 * @property int $id
 * @property string $model
 * @property int $foreign_key
 * @property string $name
 * @property string $value
 * @property string $type
 * @property string $options
 * @property bool $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Meta extends Entity
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
