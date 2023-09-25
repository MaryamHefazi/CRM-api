<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
       $request->validate([
           'name' => 'required',
           'email' => 'required',
           'password' => 'required',
       ]);

       $user = User::create($request->toArray());

       return response()->json([
            'user' => $user,
            'status' => 'create successfully',
       ] , 201);

    }


    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'the provided credentials invalid... try again!'
            ]);
            return response()->json([
                'status' => 'Unprocessable Content',
            ] , 422);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        // dd(auth()->user());

        return response()->json([
            'token' => $token,
            'status' => 'success'
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


    public function sendEmail()
    {
        $user = auth()->user();
        Mail::to($user->email)->send(new Email());
        return response()->json([
            'message' => 'email sent successfully',
            'status' => 'success'
        ] , 200);
    }
}

