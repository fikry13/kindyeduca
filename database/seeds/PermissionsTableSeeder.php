<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'student']);

        /*Permission::create(['name' => 'request session']);
        Permission::create(['name' => 'respond session']);

        Permission::create(['name' => 'see session details']);*/
    }

}