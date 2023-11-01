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
use SoapClient;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['register' , 'login']);
    }



    public function register(RegisterRequest $request)
    {
       $userR = User::create($request->toArray());
       
       $userR->assignRole('default');

       RegisterJob::dispatch($request->email);

       $client = new SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
            $user = "maryamhefazi34"; 
            $pass = "Mh810304"; 
            $fromNum = "+983000505"; 
            $toNum = ["9364707714"]; 
            $pattern_code = "jq82v3irg5ixduu"; 
            $input_data = ["name" => $request->name,"username" => $request->email]; 

	        echo $client->sendPatternSms($fromNum,$toNum,$user,$pass,$pattern_code,$input_data);

       return response()->json([
            'user' => $userR,
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

        LoginJob::dispatch($request->email);
        
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