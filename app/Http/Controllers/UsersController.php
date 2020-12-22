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
        return response()->json([
            'success' => true,
            'answer' => null
        ]);
    }

    public function update() {
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
