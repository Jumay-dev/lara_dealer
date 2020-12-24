<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Symfony\Component\Security\Core\Security;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
        $name = request('name');
        $email = request('email');
        $password = request('password');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        $user->assignRole('employee');
        // $user->save();

        return response()->json(['message' => 'Successfully registration!', 'success' => true]);
    }

    public function read() {
        $id = request(['id']);
        if (Auth::check()) {
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
        else {
            return response()->json([
                'success' => false,
                'answer' => 'user is not logged in'
            ]);
        }

    }

    public function update() {
        $user = json_decode(request('user'));
        $user_meta = json_decode(request('user_meta'));
        if (Auth::check()) {
            $quser = auth()->user();
            //$quser->getPermissionsViaRoles()
            if ($quser->hasPermissionTo('project_create')) {
                if($user) {
                    DB::table('users')->where('id', $user->id)->update([
                        'name' => $user->name,
                        'email' => $user->email,
                    ]);
                    if ($user_meta) {
                        if(DB::table('meta_users')->where('user_id', $user->id)->first()) {
                            DB::table('meta_users')->where('user_id', $user->id)->update([
                                'user_id' => $user->id,
                                'name' => $user_meta->name,	
                                'surname' => $user_meta->surname,	
                                'patronymic' => $user_meta->patronymic,
                                'phone' => $user_meta->phone,	
                                'email' => $user->email,	
                                'company_id' => $user_meta->company_id,	
                                'created_by' => $user_meta->created_by,
                                'updated_by' => $user_meta->updated_by
                            ]);
                            return response()->json([
                                'success' => true,
                                'message' => 'user and meta updated',
                            ]);
                        } else {
                            DB::table('meta_users')->insert([
                                'user_id' => $user->id,
                                'name' => $user_meta->name,	
                                'surname' => $user_meta->surname,	
                                'patronymic' => $user_meta->patronymic,
                                'phone' => $user_meta->phone,	
                                'email' => $user->email,	
                                'company_id' => $user_meta->company_id,	
                                'created_by' => $user_meta->created_by,
                                'updated_by' => $user_meta->updated_by
                            ]);
                            return response()->json([
                                'success' => true,
                                'message' => 'user updated and meta created'
                            ]);
                        }
                    }
                    return response()->json([
                        'success' => true,
                        'message' => 'user updated'
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'user not setted'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'access denied by permission policy'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'answer' => 'user is not logged in'
            ]);
        }

    }

    public function delete() {
        $user = request(['user']);
        if (Auth::check()) {
            DB::table('meta_users')->where('user_id', $user['id'])->delete();
            DB::table('model_has_roles')->where('model_id', $user['id'])->delete();
            DB::table('users')->where('id', $user['id'])->delete();
    
            if(DB::table('users')->where('id', $user['id'])) {
                return response()->json([
                    'success' => true,
                    'message' => 'user deleted succeffuly with its meta and roles'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'user deleting failed'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'user is not logged in'
            ]);
        }
    }

    public function search() {
        if (Auth::check()) {
            $q = request('q');
            $result = DB::table('users')->where('name', 'LIKE', "%$q%")->orWhere('email', 'LIKE', "%$q%")->get();
            // $result = DB::table('users')->whereRaw("MATCH(name,email) AGAINST(? IN BOOLEAN MODE)", array($q))->get();
            return response()->json([
                'success' => true,
                'answer' => $result,
                'request' => $q
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'user is not logged in'
            ]);
        }
    }
}