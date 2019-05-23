<?php

namespace Modules\Account\Validators;

use Illuminate\Contracts\Validation\Factory;

/**
 * Class Validator
 * @package Modules\Account\Validators
 */
abstract class Validator
{
    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory(): \Illuminate\Contracts\Validation\Factory
    {
        return app(Factory::class);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function validate(array $params)
    {
        return $this->getValidationFactory()
            ->make($params, $this->getRules())
            ->validate();
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Support\MessageBag
     */
    public function getMessageBag(array $params): \Illuminate\Contracts\Support\MessageBag
    {
        return $this->getValidationFactory()
            ->make($params, $this->getRules())->getMessageBag();
    }

    /**
     * @return array
     */
    abstract protected function getRules(): array;
}