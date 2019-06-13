<?php

namespace Modules\Account\Repositories;

use DB;

/**
 * Class UserHasRoleRepository
 * @package Modules\Account\Repositories
 */
class UserHasRoleRepository
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
            ->select('users.id AS user_id', 'users.name AS user_name', 'users.email AS user_email',
                'users.created_at AS user_created_at', 'users.updated_at AS user_updated_at',
                'roles.id AS role_id', 'roles.name AS role_name', 'roles.guard_name AS role_guard_name',
                'roles.created_at AS role_created_at', 'roles.updated_at AS role_updated_at')
            ->join('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')->where('model_has_roles.model_type', '=', 'Modules\Account\Entities\User');
            })->join('roles', function($join) {
                $join->on('roles.id', '=', 'model_has_roles.role_id');
            })->orderBy($column, $order)->paginate($elementsPerPage);
    }
}