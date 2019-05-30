<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\User;
use Spatie\Permission\Models\Role;

class AssignRoleToUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('account::assignroletouser.index');
    }

    public function form()
    {
        $users = User::all();
        $roles = Role::all();

        return view('account::assignroletouser.form', compact('users', 'roles'));
    }

    public function assign()
    {

    }
}
