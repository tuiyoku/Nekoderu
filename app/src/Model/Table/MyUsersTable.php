<?php
namespace App\Model\Table;

use CakeDC\Users\Model\Table\UsersTable;

/**
 * Users Model
 */
class MyUsersTable extends UsersTable
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->hasMany('Cats', [
            'foreignKey' => 'users_id'
        ]);
        $this->hasMany('Favorites', [
            'foreignKey' => 'users_id'
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'users_id'
        ]);
    }

}