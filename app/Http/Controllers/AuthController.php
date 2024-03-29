<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//use Illuminate\Foundation\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized', 'success' => false], 401);
        }

        $user = auth()->user();
        $user['id'] = auth()->id();
        $user['roles'] = auth()->user()->getRoleNames();
        $company = $user->company;
        try {
            $company['director'] = $user->find($company->director_id);
        } catch (\Exception $error) {
            $company['director'] = $error->getMessage();
        }

        $user['company'] = $company;

        return response()->json([
            'token' => $this->respondWithToken($token),
            'user' => $user,
            'success' => true,
        ]);
    }

    /**
     * User registration
     */
    public function registration()
    {
        $login = request('login');
        $email = request('email');
        $password = request('password');

        $user = User::create([
            'login' => $login,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        $user->assignRole('employee');
//         $user->save();

        return response()->json(['message' => 'Successfully registration!', 'success' => true]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        $user['roles'] = auth()->user()->getRoleNames();
        $user['id'] = auth()->id();

        $company = $user->company;
        try {
            $company['director'] = $user->find($company->director_id);
        } catch (\Exception $error) {
            $company['director'] = $error->getMessage();
        }
        $user['company'] = $company;

        return response()->json([
            'user' => $user,
            'success' => true,
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
