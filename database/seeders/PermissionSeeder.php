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
            ['name' => 'client-index', 'guard_name' => 'api'],
            ['name' => 'client-view', 'guard_name' => 'api'],
            ['name' => 'client-create', 'guard_name' => 'api'],
            ['name' => 'client-update', 'guard_name' => 'api'],
            ['name' => 'client-delete', 'guard_name' => 'api'],
            ['name' => 'client-restore', 'guard_name' => 'api'],
            ['name' => 'client-force-delete', 'guard_name' => 'api'],

            ['name' => 'project-index', 'guard_name' => 'api'],
            ['name' => 'project-view', 'guard_name' => 'api'],
            ['name' => 'project-create', 'guard_name' => 'api'],
            ['name' => 'project-update', 'guard_name' => 'api'],
            ['name' => 'project-delete', 'guard_name' => 'api'],
            ['name' => 'project-restore', 'guard_name' => 'api'],
            ['name' => 'project-force-delete', 'guard_name' => 'api'],
            ['name' => 'project-manage-media', 'guard_name' => 'api'],

            ['name' => 'task-index', 'guard_name' => 'api'],
            ['name' => 'task-view', 'guard_name' => 'api'],
            ['name' => 'task-create', 'guard_name' => 'api'],
            ['name' => 'task-update', 'guard_name' => 'api'],
            ['name' => 'task-delete', 'guard_name' => 'api'],
            ['name' => 'task-restore', 'guard_name' => 'api'],
            ['name' => 'task-force-delete', 'guard_name' => 'api'],
            ['name' => 'task-manage-media', 'guard_name' => 'api'],
            ['name' => 'task-add-response', 'guard_name' => 'api'],

            ['name' => 'response-delete', 'guard_name' => 'api'],
        ], ['name']);
    }
}
