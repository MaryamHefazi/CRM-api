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

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except([]);
    }



    public function register(Request $request)
    {
       $request->validate([
           'name' => 'required',
           'email' => 'required',
           'password' => 'required',
       ]);

       $user = User::create($request->toArray());
       
       $user->assignRole('default');

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



    public function index()
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
            'status' => 'success',
        ] , 200);
    }

    

    
    public function store(Request $request)
    {
        $request->validate([
            'firstName'=>'required|max:50',
            'middleName'=>'sometimes|max:50',
            'lastName'=>'required|max:50',
            'email'=>'required',
            'birthDate'=>'required',
            'nationalCode'=>'required',
            'gender'=>'sometimes',
            'phoneNumber'=>'required',
            'country'=>'required',
            'city'=>'required',
            'address'=>'required',
            'education'=>'sometimes',
            'job'=>'sometimes',
            'password'=>'required',

        ]);

        $user = User::create($request->toArray());
        return response()->json([
           'user' => $user,
           'status' => 'Created Successfully'
       ] , 201);
    }



    public function show(string $id)
    {
        $user = User::find($id);

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

    

    public function update(Request $request, string $id)
    {
        $request->validate([
            'firstName'=>'sometimes|max:50',
            'middleName'=>'sometimes|max:50',
            'lastName'=>'sometimes|max:50',
            'email'=>'sometimes',
            'birthDate'=>'sometimes',
            'nationalCode'=>'sometimes',
            'gender'=>'sometimes',
            'phoneNumber'=>'sometimes',
            'country'=>'sometimes',
            'city'=>'sometimes',
            'address'=>'sometimes',
            'education'=>'sometimes',
            'job'=>'sometimes',
        ]);

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


