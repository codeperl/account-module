<?php

namespace Modules\Account\Repositories;

use Modules\Account\Enums\RoleFields;
use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository
 * @package Modules\Account\Repositories
 */
class RoleRepository
{
    /**
     * @param array $params
     * @return Role
     */
    public function create(array $params): Role
    {
        return Role::create([
            RoleFields::NAME => $params[RoleFields::NAME],
            RoleFields::GUARD_NAME => $params[RoleFields::GUARD_NAME]
        ]);
    }

    /**
     * @param $roleName
     * @param $guardName
     * @return Role
     */
    public function findByNameAndGuardName($roleName, $guardName) : Role
    {
        return Role::where([
            'name' => $roleName,
            'guard_name' => $guardName
        ])->first();
    }
}