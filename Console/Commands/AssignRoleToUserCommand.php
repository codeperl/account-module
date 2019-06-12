<?php

namespace Modules\Account\Console\Commands;

use Illuminate\Console\Command;
use Modules\Account\Repositories\UserRepository;
use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Enums\AssignRoleToUserFields;

/**
 * Class AssignRoleToUserCommand
 * @package Modules\Account\Console\Commands
 */
class AssignRoleToUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "account:assignroletouser  {--name= : Existing name} {--role= : Existing role} {--guard_name= : Existing guard_name} ";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Assign role to user. Example: php artisan account:assignroletouser --name=[EXISTING_NAME] --role=[EXISTING_ROLE] --guard_name=[EXISTING_GUARD_NAME]";

    /** @var UserRepository */
    protected $userRepository;

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

        $this->userRepository = new UserRepository();
        $this->roleRepository = new RoleRepository();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $assignRoleToUser = $this->filter($this->options());
        $role = $this->roleRepository->findByNameAndGuardName($assignRoleToUser[AssignRoleToUserFields::ROLE], $assignRoleToUser[AssignRoleToUserFields::GUARD_NAME]);
        $user = $this->userRepository->findByName($assignRoleToUser[AssignRoleToUserFields::NAME]);

        if($role && $user) {
            $user->assignRole([$role]);
            $this->info("Role is assigned to the user.");
        } else {
            $this->error('Role or user is missing. Please check and try again.');
        }
    }

    private function filter(array $params): array
    {
        return [
            AssignRoleToUserFields::NAME => $params[AssignRoleToUserFields::NAME],
            AssignRoleToUserFields::ROLE => $params[AssignRoleToUserFields::ROLE],
            AssignRoleToUserFields::GUARD_NAME => $params[AssignRoleToUserFields::GUARD_NAME],
        ];
    }
}
