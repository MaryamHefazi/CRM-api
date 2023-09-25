<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;


class OpportunityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except([]);
    }

    
    public function index()
    {
        $opportunities = Opportunity::all();
        return response()->json([
            'opportunities' => $opportunities ,
            'status' => 'success'
        ] , 200);
    }

    
   
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'products' => 'required',
            'number' => 'required|numeric',
            'color' => 'required',
            'price' => 'required|numeric',
            'total_price' => 'required|numeric',
            'status' => 'required'
        ]);

        $opportunity = Opportunity::create($request->toArray());

        $products = $request->products;

        $productSync = [];

        foreach ($products as $product)
        {
            $productSync[] = $product;
        }

        $opportunity->products()->attach($productSync);

        return response()->json([
            'opportunity' => $opportunity ,
            'status' => 'create successfully',
        ] , 201);
    }

    

    public function show(string $id)
    {
        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return response()->json([
                'message' => 'opportunity Not Found',
                'status' => 'Not Found'
            ] , 404);
        }

        return response()->json([
            'opportunity' => $opportunity ,
            'status' => 'success'
        ] , 200);
    }

    

    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'sometimes',
            'products' => 'sometimes',
            'number' => 'sometimes|numeric',
            'color' => 'sometimes',
            'price' => 'sometimes|numeric',
            'total_price' => 'sometimes|numeric',
            'status' => 'sometimes'
        ]);

        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return response()->json([
             'message' => 'opportunity not found',
             'status'=> 'Not Found'
            ] , 404);
         }

         $opportunity->update($request->toArray());

         if($request->products) {
            $products = $request->products;
            $productSync = [];
            foreach($products as $product)
            {
               $productSync[] = $product;
            }

            $opportunity->products()->attach($productSync);
         }

         return response()->json([
            'opportunity'=>$opportunity,
            'status'=> 'success'
         ] , 200);
 
    }

    

    public function destroy(string $id)
    {
        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return response()->json([
             'message' => 'opportunity not found',
             'status'=> 'Not Found'
            ] , 404);
         }

         $opportunity->delete();
         return response()->json([
            'message' => 'opportunity destroy successfully',
            'status' => 'success'
         ] , 200);

    }
}
