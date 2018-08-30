<?php
namespace Users\Model\Entity;

use Cake\ORM\Entity;
/**
 * Message Entity.
 *
 * @property int $id
 * @property string $title
 * @property string $message
 * @property bool $email
 * @property int $priority
 * @property bool $delete
 * @property \Cake\I18n\Time $create
 * @property \Cake\I18n\Time $modified
 * @property \Users\Model\Entity\User[] $users
 */
class Message extends Entity
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
