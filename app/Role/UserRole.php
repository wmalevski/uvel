<?php

namespace App\Role;


/***
 * Class UserRole
 * @package App\Role
 */
class UserRole {

    const ROLE_ADMIN = 'admin';
    const ROLE_CASHIER = 'cashier';
    const ROLE_STOREHOUSE = 'storehouse';
    const ROLE_MANAGER = 'manager';

    /**
     * @var array
     */
    protected static $roleHierarchy = [
        self::ROLE_ADMIN => ['*'],
        self::ROLE_STOREHOUSE => [],
        self::ROLE_MANAGER => [
            self::ROLE_CASHIER,
        ],
        self::ROLE_CASHIER => []
    ];

    /**
     * @param string $role
     * @return array
     */
    public static function getAllowedRoles(string $role)
    {
        if (isset(self::$roleHierarchy[$role])) {
            return self::$roleHierarchy[$role];
        }

        return [];
    }

    /***
     * @return array
     */
    public static function getRoleList()
    {
        return [
            static::ROLE_ADMIN =>'admin',
            static::ROLE_CASHIER => 'cashier',
            static::ROLE_MANAGER => 'manager',
            static::ROLE_STOREHOUSE => 'storehouse',
        ];
    }

}