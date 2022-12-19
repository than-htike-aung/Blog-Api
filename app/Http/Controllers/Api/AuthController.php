<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:20'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $token = $user->createToken('Blog')->accessToken;

        return ResponseHelper::success([
            'access_token' => $token
        ]);
    }

    public function login(Request $request){
       
        $request->validate([
          
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (Auth::attempt(['email'=> $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            $token = $user->createToken('Blog')->accessToken;

            return ResponseHelper::success([
                'access_token' => $token
            ]);
        }else{
            return ResponseHelper::fail([
                'message' => 'fial'
            ]);
        }
    }

    public function logout(){
        auth()->user()->token()->revoke();
        return ResponseHelper::success([
            'message' => 'Logout successfully'
        ]);
    }
}