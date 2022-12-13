<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\PrioritySeeder;
use Database\Seeders\ProjectUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            StatusSeeder::class,
            PrioritySeeder::class,
            ProjectSeeder::class,
            ProjectUserSeeder::class
        ]);
    }
}
