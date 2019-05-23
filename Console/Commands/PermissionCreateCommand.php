<?php

namespace Modules\Account\Console\Commands;

use Illuminate\Console\Command;
use Modules\Account\Enums\PermissionFields;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Validators\PermissionValidator;

/**
 * Class UserCreateCommand
 * @package Modules\Account\Console\Commands
 */
class PermissionCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "permission";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "create permission";

    /** @var PermissionValidator */
    protected $permissionValidator;

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

        $this->permissionValidator = new PermissionValidator();
        $this->permissionRepository = new PermissionRepository();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $role = $this->filter($this->options());

        try {
            $this->permissionValidator->validate($role);
            $this->permissionRepository->create($role);
            $this->info("Role created successfully!");
        } catch(\Exception $exception) {
            $messageBag = $this->permissionValidator->getMessageBag($role);
            $this->errorMessages($messageBag->getMessages());
        }
    }

    /**
     * @param array $messages
     */
    private function errorMessages(array $messages): void
    {
        foreach($messages as $field=>$message) {
            foreach($message as $mssg) {
                $this->error($mssg);
            }
        }
    }

    /**
     * @param array $params
     * @return array
     */
    private function filter(array $params): array
    {
        return [
            PermissionFields::NAME => $params[PermissionFields::NAME],
            PermissionFields::GUARD_NAME => $params[PermissionFields::GUARD_NAME]
        ];
    }
}
