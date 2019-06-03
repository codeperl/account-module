<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Managers\UserManager;
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

    /** @var UserRepository  */
    private $userRepository;

    /** @var PermissionRepository  */
    private $permissionRepository;

    /**
     * AssignPermissionsToUsersController constructor.
     * @param UserManager $userManager
     * @param UserRepository $userRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(UserManager $userManager, UserRepository $userRepository, PermissionRepository $permissionRepository)
    {
        $this->userManager = $userManager;
        $this->userRepository = $userRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('account::assignpermissionstousers.index');
    }

    public function form()
    {
        $users = $this->userRepository->all();
        $permissions = $this->permissionRepository->all();

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

        $this->userManager->givePermissionTo($request->post('permission'), $permission);

        return redirect()->route('assignPermissionsToUsers.index')
            ->with('success','Permission assigned to user successfully');
    }
}
