<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Permission;
use Modules\Account\Entities\User;

class AssignPermissionToUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('account::assignpermissiontouser.index');
    }

    public function form()
    {
        $users = User::all();
        $permissions = Permission::all();

        return view('account::assignpermissiontouser.form', compact('users', 'permissions'));
    }

    public function assign()
    {

    }
}
