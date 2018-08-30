<?php
namespace Countries\Model\Entity;

use Cake\ORM\Entity;
/**
 * Country Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property \Countries\Model\Entity\Address[] $addresses
 * @property \Countries\Model\Entity\City[] $cities
 * @property \Countries\Model\Entity\Province[] $provinces
 */
class Country extends Entity
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
