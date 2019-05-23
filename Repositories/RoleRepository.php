<?php

namespace Modules\Account\Repositories;

use Illuminate\Support\Facades\Hash;
use Modules\Account\Enums\RoleFields;
use Spatie\Permission\Models\Role;

/**
 * Class BackendCustomerUserRepository
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
            RoleFields::NAME => $params[RoleFields::NAME]
        ]);
    }
}