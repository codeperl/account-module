<?php

namespace Modules\Account\Validators;

use Modules\Account\Enums\RoleFields;

/**
 * Class RoleValidator
 * @package Modules\Account\Validators
 */
class RoleValidator extends Validator
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            RoleFields::NAME => 'required|string|max:255',
            RoleFields::GUARD_NAME => 'required|string|max:255'
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