<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;


class UsersController extends Controller
{
    public function test() {
        $user = new \App\Models\MetaUser;
        $user->name = 'Джон';
        $user->user_id = 16;
        $user->surname = 'Джон';
        $user->patronymic = 'Джон';
        $user->phone = 8909090;
        $user->email = 'Джон';
        $user->company_id = 0;
        $user->updated_by = 11;
        try {
            $user->saveOrFail();
            $result = ($user->id)?"win":"fuck";
            return response()->json([
                'success' => true,
                'result' =>$result
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }
    }

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

        $user = new \App\ExtraUser;

        $user->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        // $user->save();

        return response()->json(['message' => 'Successfully registration!', 'success' => true]);
    }

    public function read() {
        $id = request('id');
        $user = new \App\ExtraUser;

        return response()->json([
            'success' => true,
            'answer' => [
                'user' => $user->find($id),
                'meta' => $user->find($id)->meta
            ]
        ]);
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
