<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Managers\RoleManager;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Repositories\RoleHasPermissionsRepository;
use Spatie\Permission\Models\Role;

/**
 * Class RolesController
 * @package Modules\Account\Http\Controllers
 */
class RolesController extends Controller
{
    private $roleManager;

    /** @var RoleRepository */
    private $roleRepository;

    /** @var PermissionRepository */
    private $permissionRepository;

    /** @var RoleHasPermissionsRepository */
    private $roleHasPermissionsRepository;

    /** @var int */
    private $elementsPerPage;

    /**
     * RolesController constructor.
     * @param RoleManager $roleManager
     * @param RoleRepository $roleRepository
     * @param PermissionRepository $permissionRepository
     * @param RoleHasPermissionsRepository $roleHasPermissionsRepository
     */
    public function __construct(RoleManager $roleManager, RoleRepository $roleRepository, PermissionRepository $permissionRepository, RoleHasPermissionsRepository $roleHasPermissionsRepository)
    {
        $this->roleManager = $roleManager;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->roleHasPermissionsRepository = $roleHasPermissionsRepository;
        $this->elementsPerPage = 20;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $elementsPerPage = $request->get('perPage', $this->elementsPerPage);
        $roles = $this->roleRepository->paginate('id', 'DESC', $elementsPerPage);

        return view('account::roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * $elementsPerPage);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $permission = $this->permissionRepository->get();

        return view('account::roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = $this->roleRepository->create(['name' => $request->input('name'), 'guard_name' => $request->input('guard_name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success','Role created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->find($id);
        $rolePermissions = $this->permissionRepository->getRoleWithPermissionsById($id);

        return view('account::roles.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->find($id);
        $permission = $this->permissionRepository->get();
        $rolePermissions = $this->roleHasPermissionsRepository->getRoleAndPermissions($id);

        return view('account::roles.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = $this->roleRepository->update($id,
            [
                'name' => $request->input('name'),
                'guard_name' => $request->input('guard_name')
            ]
        );

        $this->roleManager->sync($role, $request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success','Role updated successfully');
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('account::roles.index')
            ->with('success','Role deleted successfully');
    }
}
