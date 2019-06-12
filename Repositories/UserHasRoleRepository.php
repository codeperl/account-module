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
            ->select('users.name as user_name', 'users.email as user_email',
                'users.created_at as user_created_at', 'users.updated_at as user_updated_at', 'roles.name as role_name',
                'roles.guard_name as role_guard_name', 'roles.created_at as role_created_at',
                'roles.updated_at as role_updated_at')
            ->join('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')->where('model_has_roles.model_type', '=', 'Modules\Account\Entities\User');
            })->join('roles', function($join) {
                $join->on('roles.id', '=', 'model_has_roles.role_id');
            })->orderBy($column, $order)->paginate($elementsPerPage);
    }
}