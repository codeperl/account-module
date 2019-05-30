<?php

namespace Modules\Account\Repositories;

use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @return Collection
     */
    public function all() : Collection
    {
        return Resource::all();
    }
}