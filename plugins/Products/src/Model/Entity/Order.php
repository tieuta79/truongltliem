<?php
namespace Products\Model\Entity;

use Cake\ORM\Entity;
/**
 * Order Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $request
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $receiver
 * @property string $address
 * @property string $phone
 * @property int $fee
 * @property int $payment_id
 * @property \App\Model\Entity\Payment $payment
 * @property int $price
 * @property int $orderdetail_id
 * @property int $status
 * @property int $check
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Products\Model\Entity\Orderdetail[] $orderdetails
 */
class Order extends Entity
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
