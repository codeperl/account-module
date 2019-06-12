<?php

namespace Modules\Account\Managers;

use Modules\Account\Entities\User;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\UserRepository;

/**
 * Class UserHasPermissionManager
 * @package Modules\Account\Managers
 */
class UserHasPermissionManager
{
    /** @var UserRepository  */
    private $userRepository;

    /** @var PermissionRepository  */
    private $permissionRepository;

    /**
     * UserHasPermissionManager constructor.
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
     * @param $permissionId
     * @return \Modules\Account\Entities\User
     */
    public function unAssign($userId, $permissionId) : User
    {
        $user = $this->userRepository->findOrFail($userId);
        $permission = $this->permissionRepository->findOrFail($permissionId);

        return $user->revokePermissionTo($permission);
    }
}