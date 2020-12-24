<?php

use Illuminate\Database\Seeder;

class RoleHasPermissionsSeeder extends Seeder
{
    protected $guard_name = 'api';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin
        $admin = DB::table('roles')->where('name', 'admin')->first();
        
        //authorizator
        $authorizator = DB::table('roles')->where('name', 'authorizator')->first();
        
        //manager
        $manager = DB::table('roles')->where('name', 'manager')->first();
        $manager_permissions = [
            'employee_create', 
            'employee_read', 
            'employee_edit', 
            'employee_delete', 
            'project_create', 
            'project_read',
            'project_edit', 
            'company_create',
            'company_read',
            'company_edit'
        ];
        $role_has_permissons = [];
        foreach($manager_permissions as $permission) {
            $permission_db = DB::table('permissions')->where('name', $permission)->first();
            if ($permission_db) {
                $role_has_permissons[] = [
                    "permission_id" => $permission_db->id,
                    "role_id" => $manager->id
                ];
            }
        }
        \DB::table('role_has_permissions')->insert($role_has_permissons);

        //dealer
        $dealer = DB::table('roles')->where('name', 'dealer')->first();
        
        //employee
        $employee = DB::table('roles')->where('name', 'employee')->first();
    }
}
