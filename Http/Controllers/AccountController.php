<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Managers\PermissionHasResourceManager;
use Modules\Account\Managers\ResourcesManager;
use Modules\Account\Managers\RoleManager;
use Modules\Account\Managers\UserHasPermissionManager;
use Modules\Account\Managers\UserHasRoleManager;
use Modules\Account\Managers\UserManager;
use Modules\Account\Repositories\PermissionHasResourceRepository;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\ResourceRepository;
use Modules\Account\Repositories\RoleHasPermissionsRepository;
use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Repositories\UserHasPermissionRepository;
use Modules\Account\Repositories\UserHasRoleRepository;
use Modules\Account\Repositories\UserRepository;

/**
 * Class AccountController
 * @package Modules\Account\Http\Controllers
 */
class AccountController extends Controller
{
    /** @var ResourcesManager  */
    private $resourcesManager;

    /** @var UserManager */
    private $userManager;

    /** @var PermissionHasResourceManager */
    private $permissionHasResourceManager;

    /** @var RoleManager */
    private $roleManager;

    /** @var UserHasRoleManager */
    private $userHasRoleManager;

    /** @var UserHasPermissionManager */
    private $userHasPermissionManager;

    /** @var ResourceRepository  */
    private $resourceRepository;

    /** @var PermissionRepository  */
    private $permissionRepository;

    /** @var RoleRepository */
    private $roleRepository;

    /** @var RoleHasPermissionsRepository */
    private $roleHasPermissionsRepository;

    /** @var UserRepository  */
    private $userRepository;

    /** @var UserHasRoleRepository */
    private $userHasRoleRepository;

    /** @var UserHasPermissionRepository */
    private $userHasPermissionRepository;

    /** @var PermissionHasResourceRepository  */
    private $permissionHasResourceRepository;

    /** @var int */
    private $elementsPerPage;

    /**
     * AccountController constructor.
     * @param ResourcesManager $resourcesManager
     * @param PermissionHasResourceManager $permissionHasResourceManager
     * @param RoleManager $roleManager
     * @param UserManager $userManager
     * @param UserHasRoleManager $userHasRoleManager
     * @param UserHasPermissionManager $userHasPermissionManager
     * @param ResourceRepository $resourceRepository
     * @param PermissionRepository $permissionRepository
     * @param RoleRepository $roleRepository
     * @param RoleHasPermissionsRepository $roleHasPermissionsRepository
     * @param UserRepository $userRepository
     * @param UserHasRoleRepository $userHasRoleRepository
     * @param UserHasPermissionRepository $userHasPermissionRepository
     * @param PermissionHasResourceRepository $permissionHasResourceRepository
     */
    public function __construct(ResourcesManager $resourcesManager,
                                PermissionHasResourceManager $permissionHasResourceManager,
                                RoleManager $roleManager,
                                UserManager $userManager,
                                UserHasRoleManager $userHasRoleManager,
                                UserHasPermissionManager $userHasPermissionManager,
                                ResourceRepository $resourceRepository,
                                PermissionRepository $permissionRepository,
                                RoleRepository $roleRepository,
                                RoleHasPermissionsRepository $roleHasPermissionsRepository,
                                UserRepository $userRepository,
                                UserHasRoleRepository $userHasRoleRepository,
                                UserHasPermissionRepository $userHasPermissionRepository,
                                PermissionHasResourceRepository $permissionHasResourceRepository
    )
    {
        $this->resourcesManager = $resourcesManager;
        $this->userManager = $userManager;
        $this->permissionHasResourceManager = $permissionHasResourceManager;
        $this->roleManager = $roleManager;
        $this->userHasRoleManager = $userHasRoleManager;
        $this->userHasPermissionManager = $userHasPermissionManager;
        $this->roleRepository = $roleRepository;
        $this->roleHasPermissionsRepository = $roleHasPermissionsRepository;
        $this->userRepository = $userRepository;
        $this->userHasRoleRepository = $userHasRoleRepository;
        $this->userHasPermissionRepository = $userHasPermissionRepository;
        $this->resourceRepository = $resourceRepository;
        $this->permissionRepository = $permissionRepository;
        $this->permissionHasResourceRepository = $permissionHasResourceRepository;
        $this->elementsPerPage = 20;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $elementPerPage = $request->get('perPage', $this->elementsPerPage);
        $resources = $this->resourceRepository->paginate('uri', 'ASC', $elementPerPage);

        return view('account::index', compact('resources'))
            ->with('i', ($request->input('page', 1) - 1) * $elementPerPage);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resources(Request $request)
    {
        if ($request->ajax()) {
            $elementPerPage = $request->get('perPage', $this->elementsPerPage);
            $resources = $this->resourceRepository->paginate('uri', 'ASC', $elementPerPage);

            return view('account::account.resources', compact('resources'))
                ->with('i', ($request->input('page', 1) - 1) * $elementPerPage);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permissions(Request $request)
    {
        if ($request->ajax()) {
            $elementPerPage = $request->get('perPage', $this->elementsPerPage);
            $permissions = $this->permissionRepository->paginate('id', 'DESC', $elementPerPage);

            return view('account::account.permissions',compact('permissions'))
                ->with('i', ($request->input('page', 1) - 1) * $elementPerPage);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignResourceToPermission(Request $request)
    {
        if ($request->ajax()) {
            $elementsPerPage = $request->get('perPage', $this->elementsPerPage);

            $permissionsHasResources = $this->permissionHasResourceManager->paginate('uri', 'DESC',
                $this->elementsPerPage);
            $permissions = $this->permissionRepository->all();
            $resources = $this->resourceRepository->allOrderBy('uri', 'ASC');

            return view('account::account.assignresourcetopermission',compact('permissionsHasResources', 'permissions', 'resources'))
                ->with('i', ($request->input('page', 1) - 1) * $elementsPerPage);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roles(Request $request)
    {
        if ($request->ajax()) {
            $elementsPerPage = $request->get('perPage', $this->elementsPerPage);
            $roles = $this->roleRepository->paginate('id', 'DESC', $elementsPerPage);
            $permission = $this->permissionRepository->getExceptPublic();

            return view('account::account.roles',compact('roles', 'permission'))
                ->with('i', ($request->input('page', 1) - 1) * $elementsPerPage);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignRoleToUser(Request $request)
    {
        if ($request->ajax()) {
            $elementsPerPage = $request->get('perPage', $this->elementsPerPage);
            $usersHasRoles = $this->userHasRoleRepository->paginate('users.id', 'DESC', $elementsPerPage);

            $users = $this->userRepository->all();
            $roles = $this->roleRepository->all();

            return view('account::account.assignroletouser',compact('usersHasRoles', 'users', 'roles'))
                ->with('i', ($request->input('page', 1) - 1) * $elementsPerPage);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignPermissionToUser(Request $request)
    {
        if ($request->ajax()) {
            $elementsPerPage = $request->get('perPage', $this->elementsPerPage);
            $usersHasPermissions = $this->userHasPermissionRepository->paginate('users.id', 'DESC', $elementsPerPage);

            $users = $this->userRepository->all();
            $permissions = $this->permissionRepository->getExceptPublic();

            return view('account::account.assignpermissiontouser',compact('usersHasPermissions', 'users', 'permissions'))
                ->with('i', ($request->input('page', 1) - 1) * $elementsPerPage);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function resourcesGenerate(Request $request)
    {
        if ($request->ajax()) {
            $this->resourcesManager->sync($this->resourcesManager->findResources());
            $elementPerPage = $request->get('perPage', $this->elementsPerPage);
            $resources = $this->resourceRepository->paginate('uri', 'ASC', $elementPerPage);

            return response()->json(
                [
                    'resources' => view('account::account.resources')->with('resources', $resources)->with('success', 'Resource generated successfully.')->render()
                ]
            );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissionsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $result = $this->permissionRepository->create(['name' => $request->input('name'),
            'guard_name' => $request->input('guard_name')]);

        if($result) {
            $jsonArray = [
                'message' => [
                    'success' => 'Permission created successfully.'
                ],
                'permission' => $result
            ];
        } else {
            $jsonArray = [
                'message' => [
                    'error' => 'Permission creation failed.'
                ]
            ];
        }

        return response()->json($jsonArray);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resourcesToPermissionsAssign(Request $request)
    {
        $request->validate(
            [
                'permission' => ['required'],
                'resource' => ['required']
            ]
        );

        $result = $this->permissionHasResourceRepository->save(
            $this->permissionRepository->findOrFail($request->post('permission')),
            $request->post('resource')
        );

        if($result) {
            $jsonArray = [
                'message' => [
                    'success' => 'Resource assigned to permission successfully.'
                ],
                'permissionHasResource' => $result
            ];
        } else {
            $jsonArray = [
                'message' => [
                    'error' => 'Resource assigned to permission failed.'
                ]
            ];
        }

        return response()->json($jsonArray);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = $this->roleRepository->create(['name' => $request->input('name'),
            'guard_name' => $request->input('guard_name')]);
        $result = $role->syncPermissions($request->input('permission'));

        if($result) {
            $jsonArray = [
                'message' => [
                    'success' => 'Role created successfully.'
                ],
                'role' => $result
            ];
        } else {
            $jsonArray = [
                'message' => [
                    'error' => 'Role creation failed.'
                ]
            ];
        }

        return response()->json($jsonArray);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolesToUsersAssign(Request $request)
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
            $jsonArray = [
                'message' => [
                    'success' => 'Role assigned to user successfully.'
                ],
                'user' => $result
            ];
        } else {
            $jsonArray = [
                'message' => [
                    'error' => 'Role assigned to user failed.'
                ]
            ];
        }

        return response()->json($jsonArray);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissionsToUsersAssign(Request $request)
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
            $jsonArray = [
                'message' => [
                    'success' => 'Permission assigned to user successfully.'
                ],
                'user' => $result
            ];
        } else {
            $jsonArray = [
                'message' => [
                    'error' => 'Permission assigned to user failed.'
                ]
            ];
        }

        return response()->json($jsonArray);
    }
}