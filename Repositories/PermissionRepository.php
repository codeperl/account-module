<?php

namespace Modules\Account\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Account\Enums\PermissionFields;
use Modules\Account\Entities\Permission;
use DB;

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
     * @return Permission|null
     */
    public function findByNameAndGuardName($permissionName, $guardName) : ?Permission
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
    public function findOrFail($id)
    {
        return Permission::findOrFail($id);
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
        $permission = $this->findOrFail($id);
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
     * @param array $permissionIds
     * @param $guard
     * @return \Illuminate\Support\Collection
     */
    public function findBy(array $permissionIds, $guard) : \Illuminate\Support\Collection
    {
        return DB::table('permissions')
            ->leftJoin('permission_has_resources', 'permissions.id', '=', 'permission_has_resources.permission_id')
            ->where('permissions.guard_name', "$guard")
            ->whereIn('permissions.id', $permissionIds)->pluck('permissions.id as id');
    }

    /**
     * @param $permission
     * @param $resource
     * @param $guard
     * @return bool
     */
    public function hasPermissionBy($permission, $resource, $guard) : bool
    {
        return DB::table('permissions')
            ->leftJoin('permission_has_resources', 'permissions.id', '=', 'permission_has_resources.permission_id')
            ->leftJoin('resources', 'permission_has_resources.resource', '=', 'resources.resource')
            ->where('permissions.name', "$permission")
            ->where('permissions.guard_name', "$guard")
            ->where('resources.resource', "$resource")
            ->exists();
    }
}