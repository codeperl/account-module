<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Repositories\UserRepository;

/**
 * Class AssignRoleToUserController
 * @package Modules\Account\Http\Controllers
 */
class AssignRolesToUsersController extends Controller
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
        return view('account::assignrolestousers.index');
    }

    public function form()
    {
        $users = $this->userRepository->all();
        $roles = $this->roleRepository->all();

        return view('account::assignrolestousers.form', compact('users', 'roles'));
    }

    public function assign()
    {

    }
}
