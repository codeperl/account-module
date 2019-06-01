<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\UserRepository;

/**
 * Class AssignPermissionToUserController
 * @package Modules\Account\Http\Controllers
 */
class AssignPermissionsToUsersController extends Controller
{
    /** @var UserRepository  */
    private $userRepository;

    /** @var PermissionRepository  */
    private $permissionRepository;

    /**
     * AssignPermissionToUserController constructor.
     * @param UserRepository $userRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(UserRepository $userRepository, PermissionRepository $permissionRepository)
    {
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

    public function assign()
    {

    }
}