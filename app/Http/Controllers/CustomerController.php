<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            'customers' => $customers,
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

        $customer = Customer::create($request->toArray());
        return response()->json([
           'customer' => $customer,
           'status' => 'Created Successfully'
       ] , 201);
    }



    public function show(string $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
             return response()->json([
                'message' => 'customer not found',
                'status' => 'Not Found'
             ] , 404);
        }
        return response()->json([
            'customer'=>$customer,
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

        $customer = Customer::find($id);

        if ($customer){
            $customer->update($request->toArray()); 
            return response()->json([
                'customer' => $customer,
                'status' => 'success'
            ] , 200);
        }

        return response()->json([
            'message' => 'Customer not found',
            'status' => 'Not Found'
        ] , 404);

    }

    

    public function destroy(string $id)
    {
        $customer = Customer::find($id);

        if ($customer){
            return response()->json([
                'message' => 'Customer deleted successfully',
                'status' => 'success'
            ] , 200);
        }

        return response()->json([
            'message' => 'Customer not found',
            'status' => 'Not Found'
        ] , 404);
    }
}
