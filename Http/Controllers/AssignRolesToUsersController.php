<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Managers\UserManager;
use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Repositories\UserRepository;

/**
 * Class AssignRoleToUserController
 * @package Modules\Account\Http\Controllers
 */
class AssignRolesToUsersController extends Controller
{
    /** @var UserManager */
    private $userManager;

    /** @var UserRepository  */
    private $userRepository;

    /** @var RoleRepository  */
    private $roleRepository;

    /**
     * AssignRolesToUsersController constructor.
     * @param UserManager $userManager
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(UserManager $userManager, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userManager = $userManager;
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assign(Request $request)
    {
        $request->validate(
            [
                'user' => ['required'],
                'role' => ['required']
            ]
        );

        $this->userManager->assignRole(
            $request->post('user'),
            $this->roleRepository->findOrFail($request->post('role'))
        );

        return redirect()->route('assignRolesToUsers.index')
            ->with('success','Role assigned to user successfully');
    }
}
