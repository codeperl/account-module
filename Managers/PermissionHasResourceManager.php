<?php

namespace Modules\Account\Managers;

use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Modules\Account\Entities\PermissionHasResource;

class PermissionHasResourceManager
{
    /**
     * @param $column
     * @param $order
     * @param int $elementPerPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($column, $order, $elementPerPage = 20)
    {
        $select = ['permission_has_resources.permission_id AS permission_id', 'permission_has_resources.resource AS resource', 'resources.http_command AS http_command', 'resources.uri AS uri'];

        return PermissionHasResource::leftJoin('resources', 'resources.resource', '=',
                'permission_has_resources.resource')->orderBy($column, $order)->paginate($elementPerPage, $select);
    }
}