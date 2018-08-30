<?php
namespace Booking\Model\Entity;

use Cake\ORM\Entity;
/**
 * Booking Entity.
 *
 * @property int $id
 * @property int $content_id
 * @property \App\Model\Entity\Content $content
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property int $adults
 * @property int $children
 * @property \Cake\I18n\Time $checkin
 * @property \Cake\I18n\Time $checkout
 * @property bool $status
 * @property int $delete
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Booking extends Entity
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
