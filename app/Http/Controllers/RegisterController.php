<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] =  $user->createToken('blog')->plainTextToken;
        $success['name'] =  $user->name;

        return response()->json([
            'success' => $success
        ],201);
    }

    public function login(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('blog')->plainTextToken;
            $success['name'] =  $user->name;
            return response()->json(['user' => $success,'success' => 'User login successfully.']);
        }
            return response()->json([
                'error' => 'email or password uncorrected'
            ],401);

    }

    public function logout(){
        Auth::logout();
        return response()->json([
            'success' => 'user logged out successfully'
        ],200);
    }

    public function getUser(){
        $user = Auth::user();
        return response()->json([
            'user' => $user
        ]);
    }
}
