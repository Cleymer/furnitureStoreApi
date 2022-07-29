<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;


class AuthController extends Controller
{
    //
    public function register(Request $request){

        $validateData = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|string|min:8'
            ]
        );

        if($validateData->fails()){
            return [
                'success' => 'Can not register the user',
                'error' => $validateData->errors()
            ];
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'success' => 'the user was registered',
            'user' => $user,
            'access_token' => $token,
            'type_token' => 'bearer'
        ];

    }

    public function login(Request $request) {

        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'success' => 'The credentials are incorrect'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'type_token' => 'bearer'
        ]);

    }


    public function logout() {
        
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Log out'
        ]);

    }

}
