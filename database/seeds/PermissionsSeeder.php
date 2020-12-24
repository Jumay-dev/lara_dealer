<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [];

        $roles_crud = ['employee', 'dealer', 'manager', 'project'];
        
        foreach($roles_crud as $role) {
            $permissions[] = [
                "name" => $role . "_create",
                "guard_name" => "api"
            ];
    
            $permissions[] = [
                "name" => $role . "_read",
                "guard_name" => "api"
            ];
    
            $permissions[] = [
                "name" => $role . "_edit",
                "guard_name" => "api"
            ];
    
            $permissions[] = [
                "name" => $role . "_delete",
                "guard_name" => "api"
            ];
        }

        \DB::table('permissions')->insert($permissions);
    }
}
