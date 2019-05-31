<?php

namespace Modules\Account\Repositories;

use DB;

/**
 * Class RoleHasPermissionsRepository
 * @package Modules\Account\Repositories
 */
class RoleHasPermissionsRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function getRoleAndPermissions($id)
    {
        return DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    }
}