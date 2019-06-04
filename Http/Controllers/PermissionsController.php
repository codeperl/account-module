<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Permission;
use Modules\Account\Repositories\PermissionRepository;

/**
 * Class PermissionsController
 * @package Modules\Account\Http\Controllers
 */
class PermissionsController extends Controller
{
    /** @var PermissionRepository  */
    private $permissionRepository;

    /** @var int */
    private $elementsPerPage;

    /**
     * PermissionsController constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->elementsPerPage = 20;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $elementPerPage = $request->get('perPage', $this->elementsPerPage);
        $permissions = $this->permissionRepository->paginate('id', 'DESC', $elementPerPage);

        return view('account::permissions.index',compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * $elementPerPage);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('account::permissions.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $this->permissionRepository->create(['name' => $request->input('name'), 'guard_name' => $request->input('guard_name')]);

        return redirect()->route('permissions.index')
            ->with('success','Permission created successfully');
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Permission $permission)
    {
        return view('account::permissions.show',compact('permission'));
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        return view('account::permissions.edit',compact('permission'));
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
        ]);

        $this->permissionRepository->update($id,
            [
                'name' => $request->input('name'),
                'guard_name' => $request->input('guard_name')
            ]
        );

        return redirect()->route('permissions.index')
            ->with('success','Permission updated successfully');
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success','Permission deleted successfully');
    }
}
