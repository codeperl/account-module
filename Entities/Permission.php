<?php

namespace Modules\Account\Entities;

/**
 * Class Permission
 * @package Modules\Account\Entities
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    public function permissionHasResources() {
        return $this->hasMany(\Modules\Account\Entities\PermissionHasResource::class);
    }
}