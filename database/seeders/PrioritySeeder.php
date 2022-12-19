<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = ['Низкий', 'Средний', 'Высокий'];

        foreach ($priorities as $priority) {
            DB::table('priorities')->insert([
                'name' => $priority
            ]);
        }
    }
}
