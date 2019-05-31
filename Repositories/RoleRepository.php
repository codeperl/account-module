<?php

namespace Modules\Account\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Account\Enums\RoleFields;
use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository
 * @package Modules\Account\Repositories
 */
class RoleRepository
{
    /**
     * @param $column
     * @param $order
     * @param int $elementPerPage
     * @return LengthAwarePaginator
     */
    public function paginate($column, $order, $elementPerPage = 20) : LengthAwarePaginator
    {
        return Role::orderBy($column, $order)->paginate($elementPerPage);
    }

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

    /**
     * @return Collection
     */
    public function all() : Collection
    {
        return Role::all();
    }
}