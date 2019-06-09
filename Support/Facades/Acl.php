<?php

namespace Modules\Account\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Acl
 * @package Modules\Account\Support\Facades
 */
class Acl extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'acl';
    }
}