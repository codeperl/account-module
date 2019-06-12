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
            ->select('users.id AS userId', 'users.name AS user_name', 'users.email AS user_email',
                'users.created_at AS user_created_at', 'users.updated_at AS user_updated_at', 'permissions.id AS permissionId',
                'permissions.name AS permission_name', 'permissions.guard_name AS permission_guard_name',
                'permissions.created_at AS permission_created_at', 'permissions.updated_at AS permission_updated_at')
            ->join('model_has_permissions', function ($join) {
                $join->on('users.id', '=', 'model_has_permissions.model_id')->where('model_has_permissions.model_type', '=', 'Modules\Account\Entities\User');
            })->join('permissions', function($join) {
                $join->on('permissions.id', '=', 'model_has_permissions.permission_id');
            })->orderBy($column, $order)->paginate($elementsPerPage);
    }
}