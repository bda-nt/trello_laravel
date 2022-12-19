<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Илья',
                'surname' => 'Сотников',
                'login' => 'Ilya',
                'email' => 'ilya@1234',
                'password' => '1234',
            ],
            [
                'name' => 'Данил',
                'surname' => 'Башков',
                'login' => 'Danil',
                'email' => 'danil@1234',
                'password' => '1234',
            ],
            [
                'name' => 'Евгений',
                'surname' => 'Шинкарев',
                'login' => 'Evgeniy',
                'email' => 'evgeniy@1234',
                'password' => '1234',
            ],
            [
                'name' => 'Елизавета',
                'surname' => 'Осипова',
                'login' => 'Osipova',
                'email' => 'osipova@1234',
                'password' => '1234',
            ],
            [
                'name' => 'Елизавета',
                'surname' => 'Смирнова',
                'login' => 'Smirnova',
                'email' => 'smirnova@1234',
                'password' => '1234',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'surname' => $user['surname'],
                'login' => $user['login'],
                'email' => $user['email'],
                'password' => bcrypt($user['password'])
            ]);
        }
    }
}
