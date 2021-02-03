<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         /**
         * I know I could use faker 
         * I wanted these lovely users on the app 
         * ＼(^o^)／
         * */ 
        $users = [
            [
                "username" => 'spacex',
                "first_name" => 'elon',
                "last_name" => 'musk',
                "dark_mode" => 1
            ],
            [
                "username" => 'samurai',
                "first_name" => 'miyamoto',
                "last_name" => 'musashi',
                "dark_mode" => 0
            ],
            [
                "username" => 'ghibli',
                "first_name" => 'hayao',
                "last_name" => 'miyazaki',
                "dark_mode" => 0
            ],
            [
                "username" => 'dubious',
                "first_name" => 'todd',
                "last_name" => 'howard',
                "dark_mode" => 0
            ],
            [
                "username" => 'wallet-bully',
                "first_name" => 'gabe',
                "last_name" => 'newell',
                "dark_mode" => 1
            ],
            [
                "username" => 'linux',
                "first_name" => 'linus',
                "last_name" => 'trovalds',
                "dark_mode" => 1
            ],
            [
                "username" => 'winning',
                "first_name" => 'charlie',
                "last_name" => 'sheen',
                "dark_mode" => 0
            ]
        ];
        /**
         * Time to populate the database
         * (^_−)−☆
         *  */ 
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
