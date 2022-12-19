<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectUsers = [
            [
                'project_id' => 1,
                'user_id' => 3
            ],
            [
                'project_id' => 1,
                'user_id' => 5
            ],

            [
                'project_id' => 2,
                'user_id' => 1
            ],
            [
                'project_id' => 2,
                'user_id' => 2
            ],

            [
                'project_id' => 3,
                'user_id' => 4
            ],

            [
                'project_id' => 4,
                'user_id' => 1
            ],
            [
                'project_id' => 4,
                'user_id' => 2
            ],
            [
                'project_id' => 4,
                'user_id' => 3
            ],
            [
                'project_id' => 4,
                'user_id' => 4
            ],
            [
                'project_id' => 4,
                'user_id' => 5
            ],

            [
                'project_id' => 5,
                'user_id' => 1
            ],
            [
                'project_id' => 5,
                'user_id' => 2
            ],
            [
                'project_id' => 5,
                'user_id' => 3
            ],
            [
                'project_id' => 5,
                'user_id' => 4
            ],
            [
                'project_id' => 5,
                'user_id' => 5
            ],
        ];

        foreach ($projectUsers as $projectUser) {
            DB::table('user_project')->insert([
                'project_id' => $projectUser['project_id'],
                'user_id' => $projectUser['user_id']
            ]);
        }
    }
}
