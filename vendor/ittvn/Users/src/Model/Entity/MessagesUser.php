<?php
namespace Users\Model\Entity;

use Cake\ORM\Entity;
/**
 * MessagesUser Entity.
 *
 * @property int $id
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $message_id
 * @property \App\Model\Entity\Message $message
 * @property bool $read
 * @property \Cake\I18n\Time $date
 */
class MessagesUser extends Entity
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
