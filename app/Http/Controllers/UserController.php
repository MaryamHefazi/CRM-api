<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['register' , 'login']);
    }


    public function index()
    {
        $user = auth()->user();
        
        if($user->hasPermissionTo('users.all')){
            $users = User::all();
        }
        elseif($user->hasPermissionTo('users.all.user')){
            $users = User::where('id' , $user->id)->first();
        }
      
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
        
        $user->assignRole($request->role_name);

        return response()->json([
           'user' => $user,
           'status' => 'Created Successfully'
       ] , 201);
    }



    public function show($id)
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

    

    public function update(UpdateUserRequest $request, string $id)
    {
        $userLoggedIn = auth()->user();

        if($userLoggedIn->hasPermissionTo('users.update') || ($userLoggedIn->hasPermissionTo('users.update.user') && $userLoggedIn->id == $id) ){

            $user = User::find($id);
            if ($user){
                $user->update($request->toArray()); 
                return response()->json([
                    'user' => $user,
                    'status' => 'success'
                ] , 200);
            }
        }
        return response()->json([
            'message' => 'User not found or you are not allowed to update',
            'status' => 'Failed updating'
        ] , 404);

    }

    

    public function destroy(string $id)
    {
        $userLoggedIn = auth()->user();

        if($userLoggedIn->hasPermissionTo('users.update') || ($userLoggedIn->hasPermissionTo('users.update.user') && $userLoggedIn->id == $id)){

            $user = User::find($id);

            if ($user){
                $user->delete();
                return response()->json([
                    'message' => 'User deleted successfully',
                    'status' => 'success'
                ] , 200);
            }
        }
        return response()->json([
            'message' => 'User not found or you are not allowed to delete',
            'status' => 'Failed deleting'
        ] , 404);
    }
}


