<?php

namespace Modules\Account\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Account\Enums\Guards;
use Modules\Account\Enums\Permissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\PermissionHasResourceRepository;

/**
 * Class Acl
 * @package Modules\Account\Http\Middleware
 */
class Acl
{
    /** @var PermissionRepository */
    private $permissionRepository;

    /** @var PermissionHasResourceRepository */
    private $permissionHasResourceRepository;

    /**
     * Acl constructor.
     * @param PermissionRepository $permissionRepository
     * @param PermissionHasResourceRepository $permissionHasResourceRepository
     */
    public function __construct(PermissionRepository $permissionRepository, PermissionHasResourceRepository $permissionHasResourceRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->permissionHasResourceRepository = $permissionHasResourceRepository;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!app('auth')->guest() && app('auth')->user()->can(Permissions::PERMIT_ALL)) {
            return $next($request);
        }

        $currentRoute = $request->route();
        $action = $currentRoute->getAction();
        $resource = '';

        if(!empty($action['controller'])) {
            $resource = $action['controller'];
        }

        $permission = $this->permissionRepository->findByNameAndGuardName(Permissions::PUBLIC,
            $this->getCurrentGuardName());

        if($permission &&
            $this->permissionHasResourceRepository->has(
                $permission,
                $resource)
        ) {
            return $next($request);
        }

        $permissions = [];
        $permissionsHasResources = $this->permissionHasResourceRepository->getPermissionsBy($resource);
        // Check permissions are available for current user. If not throw unauthorized error.
        foreach ($permissionsHasResources as $permissionHasResource) {
            $permission = $permissionHasResource->permission->name;
            $permissions[] = $permission;
            if (app('auth')->user()->can($permission)) {
                return $next($request);
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }

    /**
     * @return string
     */
    private function getCurrentGuardName()
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
