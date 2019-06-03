<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\Permission;
use Modules\Account\Entities\PermissionHasResource;
use Modules\Account\Entities\Resource;

/**
 * Class PermissionHasResourceRepository
 * @package Modules\Account\Repositories
 */
class PermissionHasResourceRepository
{
    /**
     * @param Permission $permission
     * @param $resource
     * @return PermissionHasResource
     */
    public function save(Permission $permission, $resource) : PermissionHasResource
    {
        if(!$permissionHasResource = $this->findBy($permission, $resource)) {
            $permissionHasResource = new PermissionHasResource();
            $permissionHasResource->resource = $resource;
            $permissionHasResource->permission()->associate($permission);
            $permissionHasResource->save();
        }

        return $permissionHasResource;
    }

    /**
     * @param Permission $permission
     * @param $resource
     * @return PermissionHasResource|null
     */
    public function findBy(Permission $permission, $resource) : ?PermissionHasResource
    {
        return PermissionHasResource::where([
            'permission_id' => $permission->id,
            'resource' => $resource
        ])->first();
    }
}