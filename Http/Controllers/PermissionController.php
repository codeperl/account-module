<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Repositories\PermissionRepository;

/**
 * Class PermissionController
 * @package Modules\Account\Http\Controllers
 */
class PermissionController extends Controller
{
    /** @var PermissionRepository  */
    private $permissionRepository;

    /** @var int */
    private $elementsPerPage;

    /**
     * PermissionController constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->elementsPerPage = 20;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $elementPerPage = $request->get('perPage', $this->elementsPerPage);
        $permissions = $this->permissionRepository->paginate('id', 'DESC', $elementPerPage);

        return view('account::permission.index',compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * $elementPerPage);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('account::permission.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
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
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $permission = $this->permissionRepository->find($id);

        return view('account::permission.show',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $permission = $this->permissionRepository->find($id);

        return view('account::permission.edit',compact('permission'));
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
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->permissionRepository->delete($id);

        return redirect()->route('permissions.index')
            ->with('success','Permission deleted successfully');
    }
}
