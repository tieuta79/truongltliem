<?php
namespace Translates\Model\Entity;

use Cake\ORM\Entity;
/**
 * Translate Entity.
 *
 * @property int $id
 * @property int $language_id
 * @property \App\Model\Entity\Language $language
 * @property int $locale_id
 * @property \App\Model\Entity\Locale $locale
 * @property string $msgstr
 */
class Translate extends Entity
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
