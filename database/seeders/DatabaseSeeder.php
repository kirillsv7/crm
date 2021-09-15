<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (Storage::disk(config('media-library.disk_name'))->directories() as $directory) {
            Storage::disk(config('media-library.disk_name'))->deleteDirectory($directory);
        }

        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            ClientSeeder::class,
            ProjectSeeder::class,
            TaskSeeder::class,
            ResponseSeeder::class,
        ]);
    }
}
