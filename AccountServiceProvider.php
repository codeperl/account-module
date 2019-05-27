<?php

namespace Modules\Account;

use Illuminate\Support\ServiceProvider;

/**
 * Class AccountServiceProvider
 * @package Modules\Account
 */
class AccountServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            \Modules\Account\Console\Commands\UserCreateCommand::class,
            \Modules\Account\Console\Commands\RoleCreateCommand::class,
            \Modules\Account\Console\Commands\PermissionCreateCommand::class,
            \Modules\Account\Console\Commands\AssignPermissionToRoleCommand::class,
            \Modules\Account\Console\Commands\AssignPermissionToUserCommand::class,
            \Modules\Account\Console\Commands\AssignRoleToUserCommand::class,
        ]);
    }
}
