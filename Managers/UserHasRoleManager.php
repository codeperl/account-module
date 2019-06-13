<?php

namespace Modules\Account\Managers;

use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Repositories\UserRepository;

/**
 * Class UserHasRoleManager
 * @package Modules\Account\Managers
 */
class UserHasRoleManager
{
    /** @var UserRepository  */
    private $userRepository;

    /** @var RoleRepository  */
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param $userId
     * @param $roleId
     * @return \Modules\Account\Entities\User|null
     */
    public function unAssign($userId, $roleId)
    {
        $user = $this->userRepository->findOrFail($userId);
        $role = $this->roleRepository->findOrFail($roleId);

        if($user->hasRole($role)){
            return $user->removeRole($role);
        }

        return null;
    }
}