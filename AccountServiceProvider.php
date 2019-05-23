<?php

namespace Spatie\Permission;

use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            \Modules\Account\Console\Commands\UserCreateCommand::class,
        ]);
    }
}
