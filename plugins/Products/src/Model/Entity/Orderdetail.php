<?php
namespace Products\Model\Entity;

use Cake\ORM\Entity;
/**
 * Orderdetail Entity.
 *
 * @property int $id
 * @property int $content_id
 * @property \App\Model\Entity\Content $content
 * @property int $order_id
 * @property int $price
 * @property int $quantity
 * @property int $total
 * @property \Products\Model\Entity\Order[] $orders
 */
class Orderdetail extends Entity
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
