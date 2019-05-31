<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\User;
use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Repositories\UserRepository;
use Spatie\Permission\Models\Role;

/**
 * Class AssignRoleToUserController
 * @package Modules\Account\Http\Controllers
 */
class AssignRoleToUserController extends Controller
{
    /** @var UserRepository  */
    private $userRepository;

    /** @var RoleRepository  */
    private $roleRepository;

    /**
     * AssignRoleToUserController constructor.
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

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
        $users = $this->userRepository->all();
        $roles = $this->roleRepository->all();

        return view('account::assignroletouser.form', compact('users', 'roles'));
    }

    public function assign()
    {

    }
}
