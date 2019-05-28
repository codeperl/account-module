<?php

namespace Modules\Account\Console\Commands;

use Illuminate\Console\Command;
use Modules\Account\Enums\AssignResourceToPermissionFields;
use Modules\Account\Repositories\PermissionHasResourceRepository;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\ResourceRepository;

/**
 * Class AssignResourceToPermissionCommand
 * @package Modules\Account\Console\Commands
 */
class AssignResourceToPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "account:assignresourcetopermission {--permission= : Existing permission} {--permission_guard_name= : Existing guard name for permission} {--resource= : Existing resource}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Assign resource to permission. Example: php artisan account:assignresourcetopermission --permission=[EXISTING_PERMISSION] --permission_guard_name=[EXISTING_PERMISSION_GUARD_NAME] --resource=[EXISTING_RESOURCE]";

    /** @var PermissionRepository */
    protected $permissionRepository;

    /** @var ResourceRepository */
    protected $resourceRepository;

    /** @var PermissionHasResourceRepository */
    protected $permissionHasResourceRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->permissionRepository = new PermissionRepository();
        $this->resourceRepository = new ResourceRepository();
        $this->permissionHasResourceRepository = new PermissionHasResourceRepository();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $assignResourceToPermission = $this->filter($this->options());
        $permission = $this->permissionRepository->findByNameAndGuardName($assignResourceToPermission[AssignResourceToPermissionFields::PERMISSION], $assignResourceToPermission[AssignResourceToPermissionFields::PERMISSION_GUARD_NAME]);
        $resource = $this->resourceRepository->find($assignResourceToPermission[AssignResourceToPermissionFields::RESOURCE]);
        if($permission && $resource) {
            $this->permissionHasResourceRepository->save($permission, $resource);
            $this->info("Resource is assigned to permission.");
        } else {
            $this->error('Permission or resource is missing. Please check and try again.');
        }
    }

    /**
     * @param array $params
     * @return array
     */
    private function filter(array $params): array
    {
        return [
            AssignResourceToPermissionFields::PERMISSION => $params[AssignResourceToPermissionFields::PERMISSION],
            AssignResourceToPermissionFields::PERMISSION_GUARD_NAME => $params[AssignResourceToPermissionFields::PERMISSION_GUARD_NAME],
            AssignResourceToPermissionFields::RESOURCE => $params[AssignResourceToPermissionFields::RESOURCE],
        ];
    }
}
