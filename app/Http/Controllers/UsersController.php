<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $user = new \App\ExtraUser;
        $users = $user->all();
//
//        foreach($users as $user) {
//            $user['roles'] = $user->getRoleNames();
//            $user['permissions'] = $user->getAllPermissions();
//        }
//        $qu = Http::get('https://jsonplaceholder.typicode.com/posts')->json();

        return response()->json([
            'success' => true,
            'answer' => $users,
//            'q' => $qu
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

        return response()->json(['message' => 'Пользователь успешно зарегистрирован', 'success' => true]);
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
        $user = new \App\ExtraUser;
        $meta = new \App\Models\MetaUser;

        $id = request('id');
        $changes_user = json_decode(request('user'));
        $user_meta = json_decode(request('user_meta'));

        if (!isset($id)) $id = auth()->user()['id'];

        $found_user = $user->find($id);
        $found_meta = $found_user->meta;

        if ($found_user) {
            if (isset($changes_user) && $changes_user !== []) {
                foreach($changes_user as $key => $value) {
                    $found_user->$key = $value;
                }
            }

            if (isset($user_meta) && $user_meta !== []) {
                if (!$found_meta) $found_meta = $meta;
                if (!isset($user_meta -> user_id)) $user_meta->user_id = $id;
                foreach($user_meta as $key => $value) {
                    $found_meta->$key = $value;
                }
            }

            if ($found_user->saveOrFail() && $found_meta->saveOrFail()) {
                return response()->json([
                    'success' => true,
                    'result' => 'Изменения успешно сохранены',
                    'meta' => $found_meta
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'result' => 'Ошибка сохранения изменений'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'result' => 'Пользователь не найден'
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
