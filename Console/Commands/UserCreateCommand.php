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
class UserCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "account:user:create {--name= : Unique user name} {--email= : Unique e-mail} {--phone= : Unique phone} {--password= : Password} {--password_confirmation= : Re-type password}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create user for backend. Example: php artisan account:user:create --name=[YOUR_UNIQUE_USER_NAME_FOR_LOGIN] --email=[YOUR_UNIQUE_EMAIL_FOR_LOGIN] -phone=[YOUR_UNIQUE_PHONE_FOR_LOGIN]  --password=[YOUR_PASSWORD] --password_confirmation=[RE-TYPE_YOUR_PASSWORD]";

    /** @var UserRegisterValidator */
    protected $userRegisterValidator;

    /** @var UserRepository */
    protected $userRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->userRegisterValidator = new UserRegisterValidator();
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $user = $this->filter($this->options());

        try {
            $this->userRegisterValidator->validate($user);
            $this->userRepository->create($user);
            $this->info("User created successfully!");
        } catch(\Exception $exception) {
            $messageBag = $this->userRegisterValidator->getMessageBag($user);
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
            UserFields::NAME => $params[UserFields::NAME],
            UserFields::EMAIL => $params[UserFields::EMAIL],
            UserFields::PHONE => $params[UserFields::PHONE],
            UserFields::PASSWORD => $params[UserFields::PASSWORD],
            UserFields::PASSWORD_CONFIRMATION => $params[UserFields::PASSWORD_CONFIRMATION],
        ];
    }
}
