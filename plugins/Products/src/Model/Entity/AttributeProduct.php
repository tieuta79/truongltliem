<?php
namespace Products\Model\Entity;

use Cake\ORM\Entity;

/**
 * AttributeProduct Entity.
 *
 * @property int $id
 * @property int $content_id
 * @property \Products\Model\Entity\Content $content
 * @property int $attribute_id
 * @property \Products\Model\Entity\Attribute $attribute
 * @property string $value
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class AttributeProduct extends Entity
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
