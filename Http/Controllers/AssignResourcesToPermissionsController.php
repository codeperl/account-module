<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\ResourceRepository;

/**
 * Class AssignResourceToPermissionController
 * @package Modules\Account\Http\Controllers
 */
class AssignResourcesToPermissionsController extends Controller
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
        return view('account::assignresourcestopermissions.index');
    }

    public function form()
    {
        $permissions = $this->permissionRepository->all();
        $resources = $this->resourceRepository->all();

        return view('account::assignresourcestopermissions.form', compact('permissions', 'resources'));
    }

    public function assign()
    {

    }
}
