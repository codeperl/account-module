<?php

namespace Modules\Account\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Account\Enums\Guards;
use Modules\Account\Enums\Permissions;
use Modules\Account\Managers\AclManager;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\PermissionHasResourceRepository;

/**
 * Class Acl
 * @package Modules\Account\Http\Middleware
 */
class Acl
{
    /** @var AclManager */
    private $aclManager;

    /**
     * Acl constructor.
     * @param AclManager $aclManager
     */
    public function __construct(AclManager $aclManager)
    {
        $this->aclManager = $aclManager;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $currentRoute = $request->route();
        $action = $currentRoute->getAction();
        $resource = '';

        if(!empty($action['controller'])) {
            $resource = $action['controller'];
        }

        $guard = $this->aclManager->getGuard();

        if(!$resource || !$guard) {
            abort(403, 'User does not have the right permissions.');
        }

        if($this->aclManager->access($resource, $guard)) {
            return $next($request);
        } else {
            abort(403, 'User does not have the right permissions.');
        }
    }
}
