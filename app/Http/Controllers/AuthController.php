<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Tasks\Services\UserService;

class AuthController extends Controller
{ 
    private UserService $userService;
	public function __construct() {
		$this->userService = new UserService();
	}

    public function register(Request $request)
    {
        $request->validate([
			'name'=>'required|string|min:5',
			'email'=>'required|string',
            'password'=>'required|string|min:5'
		]);

        $credentials = [
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => bcrypt($request->post('password'))
        ];

        $id = $this->userService->addUser($credentials);
		$user = $this->userService->getById($id);

        return response()->json([
            'name' => $user['name'],
            'email' => $user['email']
        ]);
    }

    public function login()
    {
        $credentials = request([
            'email',
            'password'
        ]);

        $token = $this->userService->generateToken($credentials);
        if(!$token) {
             return response()->json([
                'error' => 'Unauthorized'], 401);
        }
        
        $user = $this->userService->getByEmail($credentials['email']);
        return response()->json([
            'name' => $user['name'],
            'email' => $user['email'],
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Log Out Success',
        ], 200);
    }

    public function refresh()
    {
        return response()->json([
            'access_token' => Auth::refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
