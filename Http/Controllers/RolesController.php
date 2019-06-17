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
    /** @var RoleManager */
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
    public function __construct(RoleManager $roleManager, RoleRepository $roleRepository,
                                PermissionRepository $permissionRepository, RoleHasPermissionsRepository
                                $roleHasPermissionsRepository)
    {
        $this->roleManager = $roleManager;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->roleHasPermissionsRepository = $roleHasPermissionsRepository;
        $this->elementsPerPage = 20;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $elementsPerPage = $request->get('perPage', $this->elementsPerPage);
        $roles = $this->roleRepository->paginate('id', 'DESC', $elementsPerPage);

        return view('account::roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * $elementsPerPage);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permission = $this->permissionRepository->getExceptPublic();

        return view('account::roles.create',compact('permission'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = $this->roleRepository->create(['name' => $request->input('name'),
            'guard_name' => $request->input('guard_name')]);
        $result = $role->syncPermissions($request->input('permission'));

        if($result) {
            return redirect()->route('roles.index')
                ->with('success','Role created successfully.');
        } else {
            return redirect()->route('roles.index')
                ->with('error','Role creation failed.');
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $role = $this->roleRepository->findOrFail($id);
        $rolePermissions = $this->roleRepository->getRoleWithPermissionsById($id);

        return view('account::roles.show',compact('role','rolePermissions'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $role = $this->roleRepository->findOrFail($id);
        $permission = $this->permissionRepository->getExceptPublic();
        $rolePermissions = $this->roleHasPermissionsRepository->getRoleAndPermissions($id);

        return view('account::roles.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
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

        $result = $this->roleManager->sync($this->roleRepository->findOrFail($id), $request->input('permission'));

        if($result) {
            return redirect()->route('roles.index')
                ->with('success','Role updated successfully.');
        } else {
            return redirect()->route('roles.index')
                ->with('error','Role update failed.');
        }
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $result = $role->delete();

        if($result) {
            return redirect()->route('roles.index')
                ->with('success','Role deleted successfully.');
        } else {
            return redirect()->route('roles.index')
                ->with('error','Role deletion failed.');
        }
    }
}
