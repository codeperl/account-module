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

    /**
     * @param $id
     * @return Role
     */
    public function findOrFail($id) : Role
    {
        return Role::findOrFail($id);
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        $role = $this->find($id);
        $role->name = $data['name'];
        $role->guard_name = $data['guard_name'];

        return $role->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return Role::where('id', $id)->delete();
    }

    /**
     * @param $id
     * @return Role
     */
    public function getRoleWithPermissionsById($id) : Role
    {
        return Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
    }
}