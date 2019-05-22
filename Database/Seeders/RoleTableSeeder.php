<?php

namespace Modules\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $roles = [
            'staff',
            'manager',
            'admin',
            'super_admin'
        ];


        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
