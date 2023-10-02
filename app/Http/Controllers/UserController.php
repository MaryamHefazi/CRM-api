<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\Email;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
// use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['register' , 'login']);
    }



    public function register(RegisterRequest $request)
    {
       $user = User::create($request->toArray());
       
       $user->assignRole('default');

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
            return response()->json([
                'status' => 'Unprocessable Content',
            ] , 422);
        }

        $token = $user->createToken('api_token')->plainTextToken;

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



    public function index()
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
            'status' => 'success',
        ] , 200);
    }

    

    
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        
        $user->assignRole($request->role_id);

        return response()->json([
           'user' => $user,
           'status' => 'Created Successfully'
       ] , 201);
    }



    public function show()
    {
        $user = auth()->user();

        if (!$user) {
             return response()->json([
                'message' => 'user not found',
                'status' => 'Not Found'
             ] , 404);
        }
        return response()->json([
            'user'=>$user,
            'status'=>'success'

        ], 200);
    }

    

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);

        if ($user){
            $user->update($request->toArray()); 
            return response()->json([
                'user' => $user,
                'status' => 'success'
            ] , 200);
        }

        return response()->json([
            'message' => 'User not found',
            'status' => 'Not Found'
        ] , 404);

    }

    

    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user){
            return response()->json([
                'message' => 'User deleted successfully',
                'status' => 'success'
            ] , 200);
        }

        return response()->json([
            'message' => 'User not found',
            'status' => 'Not Found'
        ] , 404);
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


