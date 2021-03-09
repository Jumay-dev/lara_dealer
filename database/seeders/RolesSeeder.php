<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [];

        $roles[] = [
            "name" => "manager",
            "guard_name" => "api"
        ];

        $roles[] = [
            "name" => "dealer",
            "guard_name" => "api"
        ];

        $roles[] = [
            "name" => "employee",
            "guard_name" => "api"
        ];

        $roles[] = [
            "name" => "authorizator",
            "guard_name" => "api"
        ];

        $roles[] = [
            "name" => "admin",
            "guard_name" => "api"
        ];

        \DB::table('roles')->insert($roles);
    }
}
