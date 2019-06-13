<?php

namespace Modules\Account\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Account\Managers\AclManager;

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
            abort(401, 'User does not have the right permissions.');
        }

        if($this->aclManager->access($resource, $guard)) {
            return $next($request);
        } else {
            abort(401, 'User does not have the right permissions.');
        }
    }
}
