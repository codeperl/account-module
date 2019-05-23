<?php

namespace Modules\Account\Repositories;

use Modules\Account\Enums\PermissionFields;
use Spatie\Permission\Models\Permission;

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
}