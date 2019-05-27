<?php

namespace Modules\Account\Console\Commands;

use Illuminate\Console\Command;
use Modules\Account\Repositories\UserRepository;
use Modules\Account\Enums\AssignPermissionToRoleFields;
use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Repositories\PermissionRepository;

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
    protected $signature = "account:assignpermissiontorole  {--role= : Existing role} {--role_guard_name= : Existing guard name for role} {--permission= : Existing permission} {--permission_guard_name= : Existing guard_name for permission}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Assign permission to role. Example: php artisan account:assignpermissiontorole --role=[EXISTING_ROLE] --role_guard_name=[EXISTING_ROLE_GUARD_NAME] --permission=[EXISTING_PERMISSION] --permission_guard_name=[EXISTING_PERMISSION_GUARD_NAME]";

    /** @var PermissionRepository */
    protected $permissionRepository;

    /** @var UserRepository */
    protected $roleRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->roleRepository = new RoleRepository();
        $this->permissionRepository = new PermissionRepository();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $assignPermissionToRole = $this->filter($this->options());
        $role = $this->roleRepository->findByNameAndGuardName($assignPermissionToRole[AssignPermissionToRoleFields::ROLE], $assignPermissionToRole[AssignPermissionToRoleFields::ROLE_GUARD_NAME]);
        $permission = $this->permissionRepository->findByNameAndGuardName($assignPermissionToRole[AssignPermissionToRoleFields::PERMISSION], $assignPermissionToRole[AssignPermissionToRoleFields::PERMISSION_GUARD_NAME]);

        if($role && $permission) {
            $role->givePermissionTo([$permission]);
            $this->info("Permission is assigned to role.");
        } else {
            $this->error('Permission or role is missing. Please check and try again.');
        }
    }

    /**
     * @param array $params
     * @return array
     */
    private function filter(array $params): array
    {
        return [
            AssignPermissionToRoleFields::ROLE => $params[AssignPermissionToRoleFields::ROLE],
            AssignPermissionToRoleFields::ROLE_GUARD_NAME => $params[AssignPermissionToRoleFields::ROLE_GUARD_NAME],
            AssignPermissionToRoleFields::PERMISSION => $params[AssignPermissionToRoleFields::PERMISSION],
            AssignPermissionToRoleFields::PERMISSION_GUARD_NAME => $params[AssignPermissionToRoleFields::PERMISSION_GUARD_NAME],
        ];
    }
}
