<?php

namespace Modules\Account\Repositories;

use Illuminate\Support\Facades\Hash;
use Modules\Account\Enums\UserFields;
use Modules\Account\Entities\User;

/**
 * Class BackendCustomerUserRepository
 * @package Modules\Account\Repositories
 */
class UserRepository
{
    /**
     * @param array $params
     * @return User
     */
    public function create(array $params): User
    {
        return User::create([
            UserFields::NAME => $params[UserFields::NAME],
            UserFields::EMAIL => $params[UserFields::EMAIL],
            UserFields::PHONE => $params[UserFields::PHONE],
            UserFields::PASSWORD => Hash::make($params[UserFields::PASSWORD]),
        ]);
    }

    /**
     * @param $name
     * @return User
     */
    public function findByName($name): User
    {
        return User::where('name', $name)->first();
    }
}