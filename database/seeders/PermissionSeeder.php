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
        Permission::upsert([
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

            ['name' => 'project-viewAny', 'guard_name' => 'web'],
            ['name' => 'project-view', 'guard_name' => 'web'],
            ['name' => 'project-create', 'guard_name' => 'web'],
            ['name' => 'project-update', 'guard_name' => 'web'],
            ['name' => 'project-delete', 'guard_name' => 'web'],
            ['name' => 'project-restore', 'guard_name' => 'web'],
            ['name' => 'project-forceDelete', 'guard_name' => 'web'],

            ['name' => 'task-viewAny', 'guard_name' => 'web'],
            ['name' => 'task-view', 'guard_name' => 'web'],
            ['name' => 'task-create', 'guard_name' => 'web'],
            ['name' => 'task-update', 'guard_name' => 'web'],
            ['name' => 'task-delete', 'guard_name' => 'web'],
            ['name' => 'task-restore', 'guard_name' => 'web'],
            ['name' => 'task-forceDelete', 'guard_name' => 'web'],
            ['name' => 'task-addResponse', 'guard_name' => 'web'],

            ['name' => 'response-delete', 'guard_name' => 'web'],
            ['name' => 'response-restore', 'guard_name' => 'web'],
            ['name' => 'response-forceDelete', 'guard_name' => 'web'],
        ], ['name']);
    }
}
