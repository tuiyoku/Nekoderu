<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cat Entity.
 *
 * @property int $id
 * @property int $time
 * @property string $locate
 * @property string $image_url
 * @property int $flg
 * @property string $comment
 * @property string $address
 * @property int $status
 */
class Cat extends Entity
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
