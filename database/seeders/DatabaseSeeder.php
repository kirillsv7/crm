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
        foreach (Storage::directories('public') as $directory) {
            Storage::deleteDirectory($directory);
        }

        $this->call([
            UserSeeder::class,
            ClientSeeder::class,
            ProjectSeeder::class,
            TaskSeeder::class,
            ResponseSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
