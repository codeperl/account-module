<?php

namespace Modules\Account\Console\Commands;

use Illuminate\Console\Command;
use Modules\Account\Enums\RoleFields;
use Modules\Account\Repositories\RoleRepository;
use Modules\Account\Validators\RoleValidator;

/**
 * Class UserCreateCommand
 * @package Modules\Account\Console\Commands
 */
class RoleCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "role:create {--name= : Unique role name} {--guard_name= : guard name}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create role. Example: php artisan role:create --name=[UNIQUE_ROLE] --guard_name=[GUARD_NAME]";

    /** @var RoleValidator */
    protected $roleValidator;

    /** @var RoleRepository */
    protected $roleRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->roleValidator = new RoleValidator();
        $this->roleRepository = new RoleRepository();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $role = $this->filter($this->options());

        try {
            $this->roleValidator->validate($role);
            $this->roleRepository->create($role);
            $this->info("Role created successfully!");
        } catch(\Exception $exception) {
            $messageBag = $this->roleValidator->getMessageBag($role);
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
            RoleFields::NAME => $params[RoleFields::NAME],
            RoleFields::GUARD_NAME => $params[RoleFields::GUARD_NAME]
        ];
    }
}
