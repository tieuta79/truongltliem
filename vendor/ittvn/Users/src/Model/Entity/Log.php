<?php
namespace Users\Model\Entity;

use Cake\ORM\Entity;
/**
 * Log Entity.
 *
 * @property int $id
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $ip
 * @property string $browser
 * @property bool $delete
 * @property \Cake\I18n\Time $create
 * @property \Cake\I18n\Time $modified
 */
class Log extends Entity
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
