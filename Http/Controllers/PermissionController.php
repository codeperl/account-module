<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Permission;
use DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::orderBy('id','DESC')->paginate(5);

        return view('account::permission.index',compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
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


        Permission::create(['name' => $request->input('name'), 'guard_name' => $request->input('guard_name')]);

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
        $permission = Permission::find($id);

        return view('account::permission.show',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);

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


        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->guard_name = $request->input('guard_name');
        $permission->save();

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
        DB::table("permissions")->where('id',$id)->delete();

        return redirect()->route('permissions.index')
            ->with('success','Permission deleted successfully');
    }
}
