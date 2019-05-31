<?php

namespace Modules\Account\Managers;

use Spatie\Permission\Models\Role;

/**
 * Class RoleManager
 * @package Modules\Account\Managers
 */
class RoleManager
{
    /**
     * @param $role
     * @param $permissions
     * @return mixed
     */
    public function sync(Role $role, $permissions)
    {
        return $role->syncPermissions($permissions);
    }
}