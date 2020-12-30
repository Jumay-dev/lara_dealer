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

    public function permisson_inject($role_name, Array $permissions = []) {
        $cur_role = DB::table('roles')->where('name', $role_name)->first();

        $role_has_permissons = [];
        foreach($permissions as $permission) {
            $permission_db = DB::table('permissions')->where('name', $permission)->first();
            if ($permission_db) {
                $role_has_permissons[] = [
                    "permission_id" => $permission_db->id,
                    "role_id" => $cur_role->id
                ];
            }
        }
        \DB::table('role_has_permissions')->insert($role_has_permissons);
    }
    public function run()
    {
        //admin
        $this->permisson_inject('admin', [
            'employee_create',
            'employee_read',
            'employee_edit',
            'employee_delete',
            'project_create',
            'project_read',
            'project_edit',
            'project_delete',
            'company_create',
            'company_read',
            'company_edit',
            'company_delete',
            'user_create',
            'user_read',
            'user_edit',
            'user_delete'
        ]);

        //authorizator
        $this->permisson_inject('authorizator', [
            'project_read',
            'project_edit',
        ]);

        //manager
        $this->permisson_inject('manager', [
            'project_read',
            'project_edit',
            'company_create',
            'company_read',
            'company_edit'
        ]);

        //dealer
        $this->permisson_inject('dealer', [
            'project_read',
            'project_edit',
            'project_create',
            'company_read',
            'employee_create',
            'employee_read',
            'employee_edit',
            'employee_delete',
        ]);

        //employee
        $this->permisson_inject('employee', [
            'project_read',
            'project_edit',
            'company_read',
        ]);
    }
}
