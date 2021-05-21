<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function all()
    {
        $user = new \App\User;
        $users = $user->all();
        foreach($users as $user) {
            $user['roles'] = $user->getRoleNames();
        }
//        $qu = Http::get('https://jsonplaceholder.typicode.com/posts')->json();

        return response()->json(
            [
                'success' => true,
                'answer' => $users,
            ]
        );
    }

    public function create()
    {
        return response()->json([
                'success' => false,
                'error' => "METHOD IS NOT REALISED"
            ]);
    }

    public function read()
    {
        return response()->json([
                'success' => false,
                'error' => "METHOD IS NOT REALISED"
            ]);
    }

    public function update()
    {
        $user = new \App\ExtraUser;
        try {
            $fields = \request(['id', 'name', 'surname', 'patronymic', 'phone', 'project_visibility']);
            $foundUser = $user->find($fields['id']);
            foreach ($fields as $key => $value) {
                if (!empty($value)) {
                    $foundUser->$key = $value;
                }
            }
            $foundUser->save();
            return response()->json(
                [
                    'success' => true,
                    'user' => $user->find($fields['id'])
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $e
                ]
            );
        }
    }

    public function delete()
    {
        return response()->json(
            [
                'success' => false,
                'error' => "METHOD IS NOT REALISED"
            ]
        );
    }

    public function search()
    {
        return response()->json(
            [
                'success' => false,
                'error' => "METHOD IS NOT REALISED"
            ]
        );
    }
}
