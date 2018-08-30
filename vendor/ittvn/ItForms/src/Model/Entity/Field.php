<?php
namespace ItForms\Model\Entity;

use Cake\ORM\Entity;
/**
 * Field Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $value
 * @property string $type
 * @property string $options
 * @property string $attributes
 * @property int $form_id
 * @property \App\Model\Entity\Form $form
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \ItForms\Model\Entity\FieldMeta[] $field_metas
 */
class Field extends Entity
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
