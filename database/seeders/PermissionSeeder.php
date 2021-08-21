<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            ['name' => 'user-viewAny', 'guard_name' => 'web'],
            ['name' => 'user-view', 'guard_name' => 'web'],
            ['name' => 'user-create', 'guard_name' => 'web'],
            ['name' => 'user-update', 'guard_name' => 'web'],
            ['name' => 'user-delete', 'guard_name' => 'web'],
            ['name' => 'user-restore', 'guard_name' => 'web'],
            ['name' => 'user-forceDelete', 'guard_name' => 'web'],

            ['name' => 'client-viewAny', 'guard_name' => 'web'],
            ['name' => 'client-view', 'guard_name' => 'web'],
            ['name' => 'client-create', 'guard_name' => 'web'],
            ['name' => 'client-update', 'guard_name' => 'web'],
            ['name' => 'client-delete', 'guard_name' => 'web'],
            ['name' => 'client-restore', 'guard_name' => 'web'],
            ['name' => 'client-forceDelete', 'guard_name' => 'web'],
        ]);
    }
}
