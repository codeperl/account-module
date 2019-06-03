<?php

namespace Modules\Account\Repositories;

use DB;

/**
 * Class UserHasPermissionRepository
 * @package Modules\Account\Repositories
 */
class UserHasPermissionRepository
{
    /**
     * @param $column
     * @param $order
     * @param int $elementsPerPage
     * @return mixed
     */
    public function paginate($column, $order, $elementsPerPage = 20)
    {
        return DB::table('users')
            ->select('users.name as user_name', 'users.email as user_email',
                'users.phone as user_phone', 'users.created_at as user_created_at',
                'users.updated_at as user_updated_at', 'permissions.name as permission_name',
                'permissions.guard_name as permission_guard_name', 'permissions.created_at as permission_created_at',
                'permissions.updated_at as permission_updated_at')
            ->join('model_has_permissions', function ($join) {
                $join->on('users.id', '=', 'model_has_permissions.model_id')->where('model_has_permissions.model_type', '=', 'Modules\Account\Entities\User');
            })->join('permissions', function($join) {
                $join->on('permissions.id', '=', 'model_has_permissions.permission_id');
            })->orderBy($column, $order)->paginate($elementsPerPage);
    }
}