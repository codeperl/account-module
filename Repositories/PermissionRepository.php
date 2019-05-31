<?php

namespace Modules\Account\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Account\Enums\PermissionFields;
use Modules\Account\Entities\Permission;
use Db;

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

    /**
     * @return Collection
     */
    public function all() : Collection
    {
        return Permission::all();
    }

    /**
     * @param $column
     * @param $order
     * @param int $elementPerPage
     * @return LengthAwarePaginator
     */
    public function paginate($column, $order, $elementPerPage = 20) : LengthAwarePaginator
    {
        return Permission::orderBy($column, $order)->paginate($elementPerPage);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Permission::find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return Permission::where('id', $id)->delete();
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $permission = $this->find($id);
        $permission->name = $data['name'];
        $permission->guard_name = $data['guard_name'];

        return $permission->save();
    }

    /**
     * @return Collection
     */
    public function get() : Collection
    {
        return Permission::get();
    }

    /**
     * @param $id
     * @return Role
     */
    public function getRoleWithPermissionsById($id) : Role
    {
        return Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    }
}