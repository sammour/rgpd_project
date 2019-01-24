<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $role
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $passkey
 * @property \Cake\I18n\FrozenTime|null $timeout
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Connect[] $connects
 */
class User extends Entity
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
        'username' => true,
        'password' => true,
        'role' => true,
        'created' => true,
        'passkey' => true,
        'timeout' => true,
        'modified' => true,
        'connects' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }

    protected function _getId($value)
    {
        if ($value < 5)
            $value = 'Admin';
        return $value;
    }
}
