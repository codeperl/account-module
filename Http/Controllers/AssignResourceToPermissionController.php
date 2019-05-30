<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Permission;
use Modules\Account\Entities\Resource;

class AssignResourceToPermissionController extends Controller
{
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
        $permissions = Permission::all();
        $resources = Resource::all();
        return view('account::assignresourcetopermission.form', compact('permissions', 'resources'));
    }

    public function assign()
    {

    }
}
