<?php
namespace Sites\Model\Entity;

use Cake\ORM\Entity;
/**
 * Site Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $database
 * @property string $publicKey
 * @property string $privateKey
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property bool $status
 * @property bool $delete
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Sites\Model\Entity\Domain[] $domains
 */
class Site extends Entity
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
