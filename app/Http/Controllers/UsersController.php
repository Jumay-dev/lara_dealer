<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Symfony\Component\Security\Core\Security;

class UsersController extends Controller
{
    public function all() {
        $credentials = request(['token']);
        // $user = getUser($credentials['token']);
        
        return response()->json([
            'success' => true,
            'answer' => User::all()
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
