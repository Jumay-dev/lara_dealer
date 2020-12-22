<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Symfony\Component\Security\Core\Security;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function all() {
        // $credentials = request(['token']);
        // $user = getUser($credentials['token']);
        $users = User::all();
        $roles = DB::table('roles')->get();
        foreach($users as $user) {
            $user_role_obj = DB::table('model_has_roles')->where('model_id', $user['id'])->first();
            $role_name = null;
            foreach($roles as $role) {
                if($role->id === $user_role_obj->role_id) {
                    $role_name = $role->name;
                }
            }
            $user['role'] = $role_name;
        }
        
        return response()->json([
            'success' => true,
            'answer' => $users
        ]);
        // return $user;
    }

    public function create() {
        return response()->json([
            'success' => true,
            'answer' => null
        ]);
    }

    public function read() {
        $id = request(['id']);
        if (isset($id)) {
            $user = DB::table('users')->where('id', $id)->first();
            if ($user !== null) {
                $user_meta = DB::table('meta_users')->where('id', $id)->first();
                return response()->json([
                    'success' => true,
                    'answer' => [
                        'user' => $user,
                        'user_meta' => $user_meta
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'answer' => 'user not found'
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'answer' => 'id is not setted'
        ]);

    }

    public function update() {
        $user = request(['user']);
        $user_meta = request(['user_meta']);
        DB::table('users')->where('id', $user['id'])->update([
            'name' => $user->name,
            'email' => $user->email,
        ]);
        if(DB::table('meta_users')->where('id', $user['id'])) {
            DB::table('meta_users')->where('id', $user['id'])->update([
                'user_id' => $user['id'],
                'name' => $user_meta['name'],	
                'surname' => $user_meta['surname'],	
                'patronymic' => $user_meta['patronymic'],
                'phone' => $user_meta['phone'],	
                'email' => $user_meta['email'],	
                'company_id' => $user_meta['company_id'],	
                'created_by' => $user_meta['created_by'],
                'updated_by' => $user_meta['updated_by']
            ]);
        } else {
            DB::table('meta_users')->insert([
                'user_id' => $user['id'],
                'name' => $user_meta['name'],	
                'surname' => $user_meta['surname'],	
                'patronymic' => $user_meta['patronymic'],
                'phone' => $user_meta['phone'],	
                'email' => $user_meta['email'],	
                'company_id' => $user_meta['company_id'],	
                'created_by' => $user_meta['created_by'],
                'updated_by' => $user_meta['updated_by']
            ]);
        }
        return response()->json([
            'success' => true,
            'answer' => null
        ]);
    }

    public function delete() {
        return response()->json([
            'success' => true,
            'answer' => null
        ]);
    }

    public function search() {
        return response()->json([
            'success' => true,
            'answer' => null
        ]);
    }
}
