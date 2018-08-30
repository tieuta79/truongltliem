<?php
namespace Products\Model\Entity;

use Cake\ORM\Entity;
/**
 * Payment Entity.
 *
 * @property int $id
 * @property string $name
 * @property int $fee
 * @property string $description
 * @property string $options
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Products\Model\Entity\Order[] $orders
 */
class Payment extends Entity
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