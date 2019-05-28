<?php

namespace Modules\Account\Repositories;

use Modules\Account\Enums\PermissionFields;
use Modules\Account\Entities\Permission;

/**
 * Class PermissionRepository
 * @package Modules\Account\Repositories
 */
class PermissionRepository
{
    /**
     * @param array $params
     * @return Permission
     */
    public function create(array $params): Permission
    {
        return Permission::create([
            PermissionFields::NAME => $params[PermissionFields::NAME],
            PermissionFields::GUARD_NAME => $params[PermissionFields::GUARD_NAME]
        ]);
    }

    /**
     * @param $permissionName
     * @param $guardName
     * @return Permission
     */
    public function findByNameAndGuardName($permissionName, $guardName) : Permission
    {
        return Permission::where([
            'name' => $permissionName,
            'guard_name' => $guardName
        ])->first();
    }
}