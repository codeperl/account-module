<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Permission;
use Modules\Account\Entities\Resource;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\ResourceRepository;

class AssignResourceToPermissionController extends Controller
{
    /** @var PermissionRepository  */
    private $permissionRepository;

    /** @var ResourceRepository  */
    private $resourceRepository;

    /**
     * AssignResourceToPermissionController constructor.
     * @param PermissionRepository $permissionRepository
     * @param ResourceRepository $resourceRepository
     */
    public function __construct(PermissionRepository $permissionRepository, ResourceRepository $resourceRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('account::assignresourcetopermission.index');
    }

    public function form()
    {
        $permissions = $this->permissionRepository->all();
        $resources = $this->resourceRepository->all();

        return view('account::assignresourcetopermission.form', compact('permissions', 'resources'));
    }

    public function assign()
    {

    }
}
