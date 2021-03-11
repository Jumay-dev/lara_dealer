<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class RoleToUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('model_has_roles')->insert([
            'role_id' => 5,
            'model_type' => "App\User",
            'model_id' => 1
    ]);
    }
}
