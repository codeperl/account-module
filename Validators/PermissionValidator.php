<?php

namespace Modules\Account\Validators;

use Modules\Account\Enums\PermissionFields;

/**
 * Class PermissionValidator
 * @package Modules\Account\Validators
 */
class PermissionValidator extends Validator
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            PermissionFields::NAME => 'required|string|max:255|unique:permissions',
            PermissionFields::GUARD_NAME => 'required|string|max:255'
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