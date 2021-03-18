<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(RoleHasPermissionsSeeder::class);
        $this->call(ToolsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(DetailsSeeder::class);
    }
}
