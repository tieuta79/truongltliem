<?php
namespace ItForms\Model\Entity;

use Cake\ORM\Entity;
/**
 * Form Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $menu
 * @property bool $list
 * @property string $before_submit
 * @property string $after_submit
 * @property string $js
 * @property string $css
 * @property bool $delete
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \ItForms\Model\Entity\Field[] $fields
 */
class Form extends Entity
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
