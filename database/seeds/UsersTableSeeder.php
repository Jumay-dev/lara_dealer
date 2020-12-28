<?php

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
        $users = [];

        $users[] = [
            'name' => 'admin',
            'email' => 'admin@lara.ru',
            'password' => '$2y$10$/wBo97n9f6U429xqBoKIFOnNXOI/4zvPLaOEGcPStVBg7FQHRL6Aa',
            'external_id' => 0
        ];
        \DB::table('users')->insert($users);
    }
}
