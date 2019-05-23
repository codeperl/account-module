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
        ]);
    }
}
