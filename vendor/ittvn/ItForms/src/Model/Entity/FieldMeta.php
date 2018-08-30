<?php
namespace ItForms\Model\Entity;

use Cake\ORM\Entity;
/**
 * FieldMeta Entity.
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property int $field_id
 * @property \App\Model\Entity\Field $field
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class FieldMeta extends Entity
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
