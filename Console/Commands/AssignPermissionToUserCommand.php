<?php

namespace Modules\Account\Console\Commands;

use Illuminate\Console\Command;
use Modules\Account\Enums\AssignPermissionToUserFields;
use Modules\Account\Repositories\UserRepository;
use Modules\Account\Repositories\PermissionRepository;

/**
 * Class UserCreateCommand
 * @package Modules\Account\Console\Commands
 */
class AssignPermissionToUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "account:assignpermissiontouser  {--username= : Existing username} {--permission= : Existing permission} {--permission_guard_name= : Existing guard_name for permission}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Assign permission to user. Example: php artisan account:assignpermissiontouser --username=[EXISTING_USER] --permission=[EXISTING_PERMISSION] --permission_guard_name=[EXISTING_PERMISSION_GUARD_NAME]";

    /** @var UserRepository */
    protected $userRepository;

    /** @var PermissionRepository */
    protected $permissionRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->userRepository = new UserRepository();
        $this->permissionRepository = new PermissionRepository();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $assignPermissionToUser = $this->filter($this->options());
        $user = $this->userRepository->findByName($assignPermissionToUser[AssignPermissionToUserFields::USER]);
        $permission = $this->permissionRepository->findByNameAndGuardName($assignPermissionToUser[AssignPermissionToUserFields::PERMISSION], $assignPermissionToUser[AssignPermissionToUserFields::PERMISSION_GUARD_NAME]);

        if($user && $permission) {
            $user->givePermissionTo([$permission]);
            $this->info("Permission is assigned to user.");
        } else {
            $this->error('Permission or user is missing. Please check and try again.');
        }
    }

    /**
     * @param array $params
     * @return array
     */
    private function filter(array $params): array
    {
        return [
            AssignPermissionToUserFields::USER => $params[AssignPermissionToUserFields::USER],
            AssignPermissionToUserFields::PERMISSION => $params[AssignPermissionToUserFields::PERMISSION],
            AssignPermissionToUserFields::PERMISSION_GUARD_NAME => $params[AssignPermissionToUserFields::PERMISSION_GUARD_NAME],
        ];
    }
}
