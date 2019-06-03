<?php

namespace Modules\Account\Managers;


use Modules\Account\Entities\Permission;
use Modules\Account\Repositories\UserRepository;
use Spatie\Permission\Models\Role;

class UserManager
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * UserManager constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
}