<?php

namespace Modules\Account\Validators;

use Modules\Account\Enums\UserFields;

/**
 * Class UserRegisterValidator
 * @package Modules\Account\Validators
 */
class UserRegisterValidator extends Validator
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            UserFields::NAME => 'required|string|max:255|unique:users',
            UserFields::EMAIL => 'required|string|email|max:255|unique:users',
            UserFields::PASSWORD => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function validate(array $params)
    {
        return parent::validate($params);
    }
}