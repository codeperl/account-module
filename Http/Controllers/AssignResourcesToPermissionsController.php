<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Repositories\PermissionHasResourceRepository;
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

    /** @var PermissionHasResourceRepository  */
    private $permissionHasResourceRepository;

    /**
     * AssignResourcesToPermissionsController constructor.
     * @param PermissionRepository $permissionRepository
     * @param ResourceRepository $resourceRepository
     * @param PermissionHasResourceRepository $permissionHasResourceRepository
     */
    public function __construct(PermissionRepository $permissionRepository, ResourceRepository $resourceRepository, PermissionHasResourceRepository $permissionHasResourceRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->resourceRepository = $resourceRepository;
        $this->permissionHasResourceRepository = $permissionHasResourceRepository;
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

    public function assign(Request $request)
    {
        $request->validate(
            [
                'permission' => ['required'],
                'resource' => ['required']
            ]
        );

        $this->permissionHasResourceRepository->save(
            $this->permissionRepository->findOrFail($request->post('permission')),
            $request->post('resource')
        );

        return redirect()->route('assignResourcesToPermissions.index')
            ->with('success','Resource assigned to permission successfully');
    }
}
