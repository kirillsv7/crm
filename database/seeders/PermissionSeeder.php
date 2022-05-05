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
            ['name' => 'client-index', 'guard_name' => 'web'],
            ['name' => 'client-view', 'guard_name' => 'web'],
            ['name' => 'client-create', 'guard_name' => 'web'],
            ['name' => 'client-update', 'guard_name' => 'web'],
            ['name' => 'client-delete', 'guard_name' => 'web'],
            ['name' => 'client-restore', 'guard_name' => 'web'],
            ['name' => 'client-force-delete', 'guard_name' => 'web'],

            ['name' => 'project-index', 'guard_name' => 'web'],
            ['name' => 'project-view', 'guard_name' => 'web'],
            ['name' => 'project-create', 'guard_name' => 'web'],
            ['name' => 'project-update', 'guard_name' => 'web'],
            ['name' => 'project-delete', 'guard_name' => 'web'],
            ['name' => 'project-restore', 'guard_name' => 'web'],
            ['name' => 'project-force-delete', 'guard_name' => 'web'],
            ['name' => 'project-manage-media', 'guard_name' => 'web'],

            ['name' => 'task-index', 'guard_name' => 'web'],
            ['name' => 'task-view', 'guard_name' => 'web'],
            ['name' => 'task-create', 'guard_name' => 'web'],
            ['name' => 'task-update', 'guard_name' => 'web'],
            ['name' => 'task-delete', 'guard_name' => 'web'],
            ['name' => 'task-restore', 'guard_name' => 'web'],
            ['name' => 'task-force-delete', 'guard_name' => 'web'],
            ['name' => 'task-manage-media', 'guard_name' => 'web'],
            ['name' => 'task-add-response', 'guard_name' => 'web'],

            ['name' => 'response-delete', 'guard_name' => 'web'],
        ], ['name']);
    }
}
