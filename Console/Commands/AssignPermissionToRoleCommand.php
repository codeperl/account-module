<?php

namespace Modules\Account\Console\Commands;

use Illuminate\Console\Command;
use Modules\Account\Enums\UserFields;
use Modules\Account\Repositories\UserRepository;
use Modules\Account\Validators\UserRegisterValidator;

/**
 * Class UserCreateCommand
 * @package Modules\Account\Console\Commands
 */
class AssignPermissionToRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "account:assignpermissiontorole";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Assign permission to role";
}
