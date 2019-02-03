<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
    	$validator = Validator::make($request->all(), [
           'email' => "required|unique:users|email",
            "password" => 'required',
            "country" => 'required',
            "name" => 'required',
            "address" => 'required',
            "isSeller" => 'required',
       ]);
        
       if ($validator->fails()) {
            return response()->json([
            	'errors' => $validator->messages()->first()
        	], 403);
       }

    	$type = "customer";
    	if($request->isSeller)
	    	$type = "seller";
        $user = User::create([
             'email'    => $request->email,
             'name'    => $request->name,
             'address'    => $request->address,
             'country'    => $request->country,
             'password' => $request->password,
             'type' => $type,
         ]);

        $token = Auth::guard('api')->login($user);

        return $this->respondWithToken($token);
    }

    public function refreshToken(Request $request) {
        $token = auth('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function login() {
        $credentials = request(['email', 'password']);
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout() {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
