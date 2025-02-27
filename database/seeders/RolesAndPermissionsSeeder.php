<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create post',
            'edit post',
            'delete post',
            'approve post',
            'reject post',
            'list post',
            'show post',
            'view users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        //create role 
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        $adminRole->givePermissionTo(Permission::all());
        $editorRole->givePermissionTo(['create post', 'edit post']);
        $userRole->givePermissionTo(['create post','show post']);
    }
}
