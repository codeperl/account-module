<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Managers\UserHasPermissionManager;
use Modules\Account\Managers\UserManager;
use Modules\Account\Repositories\UserHasPermissionRepository;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\UserRepository;

/**
 * Class AssignPermissionToUserController
 * @package Modules\Account\Http\Controllers
 */
class AssignPermissionsToUsersController extends Controller
{
    /** @var UserManager */
    private $userManager;

    /** @var UserHasPermissionManager */
    private $userHasPermissionManager;

    /** @var UserHasPermissionRepository */
    private $userHasPermissionRepository;

    /** @var UserRepository  */
    private $userRepository;

    /** @var PermissionRepository  */
    private $permissionRepository;

    /** @var int */
    private $elementsPerPage;

    /**
     * AssignPermissionsToUsersController constructor.
     * @param UserManager $userManager
     * @param UserHasPermissionManager $userHasPermissionManager
     * @param UserHasPermissionRepository $userHasPermissionRepository
     * @param UserRepository $userRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(UserManager $userManager, UserHasPermissionManager $userHasPermissionManager,
                                UserHasPermissionRepository $userHasPermissionRepository,
                                UserRepository $userRepository, PermissionRepository $permissionRepository)
    {
        $this->userManager = $userManager;
        $this->userHasPermissionManager = $userHasPermissionManager;
        $this->userHasPermissionRepository = $userHasPermissionRepository;
        $this->userRepository = $userRepository;
        $this->permissionRepository = $permissionRepository;
        $this->elementsPerPage = 20;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $elementsPerPage = $request->get('perPage', $this->elementsPerPage);
        $usersHasPermissions = $this->userHasPermissionRepository->paginate('users.id', 'DESC', $elementsPerPage);

        return view('account::assignpermissionstousers.index',compact('usersHasPermissions'))
            ->with('i', ($request->input('page', 1) - 1) * $elementsPerPage);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function form()
    {
        $users = $this->userRepository->all();
        $permissions = $this->permissionRepository->getExceptPublic();

        return view('account::assignpermissionstousers.form', compact('users', 'permissions'));
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
                'permission' => ['required']
            ]
        );

        $permission = $this->permissionRepository->findOrFail($request->post('permission'));

        $result = $this->userManager->givePermissionTo($request->post('user'), $permission);

        if($result) {
            return redirect()->route('assignPermissionsToUsers.index')
                ->with('success','Permission assigned to user successfully.');
        } else {
            return redirect()->route('assignPermissionsToUsers.index')
                ->with('error','Permission assigned to user failed.');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unAssign(Request $request)
    {
        $result = $this->userHasPermissionManager->unAssign($request->post('user'), $request->post('permission'));

        if($result) {
            return redirect()->route('assignPermissionsToUsers.index')
                ->with('success','Permission un-assigned to user successfully.');
        } else {
            return redirect()->route('assignPermissionsToUsers.index')
                ->with('error','Permission un-assigned to user failed.');
        }
    }
}
