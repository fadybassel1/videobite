<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
   public function register(Request $request)
   {
        $validatedData = $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=> $user, 'access_token'=> $accessToken]);
       
   }


   public function login(Request $request)
   {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
       
        if(!auth()->attempt($loginData)) {
            return response([
                'status' => false,
                'data' => null,
                'message' => 'Invalid credentials',
            ]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response()->json([
            'status' => true,
            'data' => [
                'user' => auth()->user(),
                'access_token' => $accessToken,
            ],
            'message' => 'success',
            ]);

   }

   public function logout()
    { 
        if (auth()->user()) {
            auth()->user()->token()->revoke();
            return response(['status' => 200]);
        }
    }
}