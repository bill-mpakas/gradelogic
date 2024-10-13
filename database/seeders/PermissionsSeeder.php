<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'create classrooms']);
        Permission::create(['name' => 'read classrooms']);
        Permission::create(['name' => 'update classrooms']);
        Permission::create(['name' => 'delete classrooms']);

        // create roles and assign existing permissions
        $role1 = Role::findByName('Super-Admin');
        $role2 = Role::findByName('teacher');
        $role3 = Role::findByName('student');
        $role4 = Role::findByName('organization');


        $role1->givePermissionTo('create classrooms');
        $role1->givePermissionTo('read classrooms');
        $role1->givePermissionTo('update classrooms');
        $role1->givePermissionTo('delete classrooms');


        $role2->givePermissionTo('create classrooms');
        $role2->givePermissionTo('read classrooms');
        $role2->givePermissionTo('update classrooms');
        $role2->givePermissionTo('delete classrooms');

        $role3->givePermissionTo('read classrooms');

        $role4->givePermissionTo('read classrooms');







    }
}
