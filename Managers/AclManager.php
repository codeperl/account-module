<?php

namespace Modules\Account\Managers;

use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\PermissionHasResourceRepository;
use Modules\Account\Enums\Permissions;

/**
 * Class AclManager
 * @package Modules\Account\Managers
 */
class AclManager
{
    /** @var PermissionRepository */
    private $permissionRepository;

    /** @var PermissionHasResourceRepository */
    private $permissionHasResourceRepository;

    /**
     * AclManager constructor.
     * @param PermissionRepository $permissionRepository
     * @param PermissionHasResourceRepository $permissionHasResourceRepository
     */
    public function __construct(PermissionRepository $permissionRepository,
                                PermissionHasResourceRepository $permissionHasResourceRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->permissionHasResourceRepository = $permissionHasResourceRepository;
    }

    /**
     * @param $resource
     * @param $guard
     * @return bool
     */
    public function access($resource, $guard) : bool
    {
        if(!app('auth')->guest() && app('auth')->user()->can(Permissions::PERMIT_ALL)) {
            return true;
        }

        $permission = $this->permissionRepository->findByNameAndGuardName(Permissions::PUBLIC,
            $guard);

        if($permission &&
            $this->permissionHasResourceRepository->has(
                $permission->id,
                $resource)
        ) {
            return true;
        }

        $permissions = [];
        $permissionsHasResources = $this->permissionHasResourceRepository->getPermissionsBy($resource);

        foreach ($permissionsHasResources as $permissionHasResource) {
            $permission = $permissionHasResource->permission->name;
            $permissions[] = $permission;
            if (app('auth')->user()->can($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getGuard()
    {
        $guard = auth()->guard();
        $sessionName = $guard->getName();
        $parts = explode("_", $sessionName);
        unset($parts[count($parts)-1]);
        unset($parts[0]);
        $guardName = implode("_",$parts);

        return $guardName;
    }
}