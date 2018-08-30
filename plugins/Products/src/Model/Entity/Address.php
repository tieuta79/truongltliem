<?php
namespace Products\Model\Entity;

use Cake\ORM\Entity;
/**
 * Address Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $company
 * @property string $phone
 * @property int $country_id
 * @property \App\Model\Entity\Country $country
 * @property int $province_id
 * @property \App\Model\Entity\Province $province
 * @property int $city_id
 * @property \App\Model\Entity\City $city
 * @property int $ward_id
 * @property \App\Model\Entity\Ward $ward
 * @property string $address
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property bool $default
 * @property bool $delete
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Address extends Entity
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
