<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Jobs\RegisterJob;
use App\Jobs\LoginJob;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['register' , 'login']);
    }



    public function register(RegisterRequest $request)
    {
       $user = User::create($request->toArray());
       
       $user->assignRole('default');

       RegisterJob::dispatch();

       return response()->json([
            'user' => $user,
            'status' => 'create successfully',
       ] , 201);

    }



    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'the provided credentials invalid... try again!'
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;
        LoginJob::dispatch();
        return response()->json([
            'token' => $token,
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'status' => 'success',
        ] , 200);
    }



    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'logout out successfully',
            'status' => 'success'
        ] , 200);
 
    }
}
