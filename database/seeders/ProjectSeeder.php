<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = ['Frontend', 'Backend', 'Дизайн', 'Проектный практикум', 'Ярус'];

        foreach ($projects as $project) {
            DB::table('projects')->insert([
                'name' => $project
            ]);
        }
    }
}
