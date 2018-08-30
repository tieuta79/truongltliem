<?php
namespace Users\Model\Entity;

use Cake\ORM\Entity;
/**
 * UsersLog Entity.
 *
 * @property int $id
 * @property int $log_id
 * @property \App\Model\Entity\Log $log
 * @property string $url
 * @property string $params
 * @property string $query
 * @property string $data
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class UsersLog extends Entity
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
