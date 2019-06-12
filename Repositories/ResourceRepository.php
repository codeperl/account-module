<?php

namespace Modules\Account\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Account\Entities\Resource;

/**
 * Class ResourceRepository
 * @package Modules\Account\Repositories
 */
class ResourceRepository
{
    /**
     * @param $column
     * @param $order
     * @param int $elementPerPage
     * @return LengthAwarePaginator
     */
    public function paginate($column, $order, $elementPerPage = 20) : LengthAwarePaginator
    {
        return Resource::orderBy($column, $order)->paginate($elementPerPage);
    }

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

    /**
     * @param $resource
     * @return bool
     */
    public function has($resource) : bool
    {
        return Resource::where(['resource' => $resource])->exists();
    }

    /**
     * @param $column
     * @param $order
     * @return mixed
     */
    public function allOrderBy($column, $order)
    {
        return Resource::orderBy($column, $order)->get();
    }
}