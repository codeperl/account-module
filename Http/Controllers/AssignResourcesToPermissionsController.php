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

    /** @var int */
    private $elementsPerPage;

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
        $this->elementsPerPage = 20;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $elementsPerPage = $request->get('perPage', $this->elementsPerPage);
        $permissionsHasResources = $this->permissionHasResourceRepository->paginate('permission_id', 'DESC', $elementsPerPage);

        return view('account::assignresourcestopermissions.index',compact('permissionsHasResources'))
            ->with('i', ($request->input('page', 1) - 1) * $elementsPerPage);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function form()
    {
        $permissions = $this->permissionRepository->all();
        $resources = $this->resourceRepository->all();

        return view('account::assignresourcestopermissions.form', compact('permissions', 'resources'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
