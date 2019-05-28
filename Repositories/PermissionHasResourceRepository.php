<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\Permission;
use Modules\Account\Entities\PermissionHasResource;
use Modules\Account\Entities\Resource;

class PermissionHasResourceRepository
{
    /**
     * @param Permission $permission
     * @param Resource $resource
     * @return PermissionHasResource
     */
    public function save(Permission $permission, Resource $resource) : PermissionHasResource
    {
        if(!$permissionHasResource = $this->findBy($permission, $resource)) {
            $permissionHasResource = new PermissionHasResource();
            $permissionHasResource->resource = $resource->resource;
            $permissionHasResource->permission()->associate($permission);
            $permissionHasResource->save();
        }

        return $permissionHasResource;
    }

    /**
     * @param Permission $permission
     * @param Resource $resource
     * @return PermissionHasResource|null
     */
    public function findBy(Permission $permission, Resource $resource) : ?PermissionHasResource
    {
        return PermissionHasResource::where([
            'permission_id' => $permission->id,
            'resource' => $resource->resource
        ])->first();
    }
}