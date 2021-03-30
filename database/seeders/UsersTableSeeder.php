<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
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
                'name' => 'AmanHrp.yahoo',
                'email' => 'amanhrp.yahoo@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'AmanHrp.dev',
                'email' => 'amanhrp.dev@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'AmanudinHrp',
                'email' => 'amanudinhrp@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Harahap Sajo Peda',
                'email' => 'harahapsajopeda@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Amanuddin Harahap',
                'email' => 'amanuddinharahap@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'User 1',
                'email' => 'user1@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'User 3',
                'email' => 'user3@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'User 4',
                'email' => 'user4@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'User 5',
                'email' => 'user5@gmail.com',
                'password' => bcrypt('12345678'),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
