<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Managers\UserHasRoleManager;
use Modules\Account\Managers\UserManager;
use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Repositories\UserHasRoleRepository;
use Modules\Account\Repositories\UserRepository;

/**
 * Class AssignRoleToUserController
 * @package Modules\Account\Http\Controllers
 */
class AssignRolesToUsersController extends Controller
{
    /** @var UserManager */
    private $userManager;

    /** @var UserHasRoleManager */
    private $userHasRoleManager;

    /** @var UserRepository  */
    private $userRepository;

    /** @var RoleRepository  */
    private $roleRepository;

    /** @var UserHasRoleRepository */
    private $userHasRoleRepository;

    /** @var int */
    private $elementsPerPage;

    /**
     * AssignRolesToUsersController constructor.
     * @param UserManager $userManager
     * @param UserHasRoleManager $userHasRoleManager
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param UserHasRoleRepository $userHasRoleRepository
     */
    public function __construct(UserManager $userManager, UserHasRoleManager $userHasRoleManager,
                                UserRepository $userRepository, RoleRepository $roleRepository,
                                UserHasRoleRepository $userHasRoleRepository)
    {
        $this->userManager = $userManager;
        $this->userHasRoleManager = $userHasRoleManager;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userHasRoleRepository = $userHasRoleRepository;
        $this->elementsPerPage = 20;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $elementsPerPage = $request->get('perPage', $this->elementsPerPage);
        $usersHasRoles = $this->userHasRoleRepository->paginate('users.id', 'DESC', $elementsPerPage);

        return view('account::assignrolestousers.index',compact('usersHasRoles'))
            ->with('i', ($request->input('page', 1) - 1) * $elementsPerPage);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

        $result = $this->userManager->assignRole(
            $request->post('user'),
            $this->roleRepository->findOrFail($request->post('role'))
        );

        if($result) {
            return redirect()->route('assignRolesToUsers.index')
                ->with('success','Role assigned to user successfully.');
        } else {
            return redirect()->route('assignRolesToUsers.index')
                ->with('error', 'Role assigned to user failed.');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unAssign(Request $request)
    {
        if($this->userHasRoleManager->unAssign(
            $request->post('user'), $request->post('role'))
        ) {
            return redirect()->route('assignRolesToUsers.index')
                ->with('success','Role un-assigned to user successfully.');
        }

        return redirect()->route('assignRolesToUsers.index')
            ->with('error','Role un-assigned to user failed.');
    }
}
