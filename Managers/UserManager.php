<?php

namespace Modules\Account\Managers;


use Modules\Account\Entities\Permission;
use Modules\Account\Entities\User;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\UserRepository;
use Spatie\Permission\Models\Role;

class UserManager
{
    /** @var UserRepository */
    private $userRepository;

    /** @var PermissionRepository */
    private $permissionRepository;

    /**
     * UserManager constructor.
     * @param UserRepository $userRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(UserRepository $userRepository, PermissionRepository $permissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param $userId
     * @param Permission $permission
     * @return \Modules\Account\Entities\User
     */
    public function givePermissionTo($userId, Permission $permission)
    {
        $user = $this->userRepository->findOrFail($userId);

        return $user->givePermissionTo([$permission]);
    }

    /**
     * @param $userId
     * @param Role $role
     * @return \Modules\Account\Entities\User
     */
    public function assignRole($userId, Role $role)
    {
        $user = $this->userRepository->findOrFail($userId);

        return $user->assignRole([$role]);
    }

    /**
     * @param User $user
     * @param array $permissionIds
     * @param $guard
     * @return bool
     * @throws \Exception
     */
    public function hasAccessTo(User $user, array $permissionIds, $guard) : bool
    {
        if($permissionIds) {
            $permissions = $this->permissionRepository->findBy($permissionIds, $guard);
            if($permissions) {
                return $user->hasAnyPermission($permissions->toArray());
            }
        }

        return false;
    }
}