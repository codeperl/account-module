<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\Resource;

class ResourceRepository
{
    /**
     * @param $resource
     * @return Resource
     */
    public function find($resource) : Resource
    {
        return Resource::where([
            'resource' => $resource
        ])->first();
    }
}