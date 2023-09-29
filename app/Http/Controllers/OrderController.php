<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except([]);
    }

    
    public function index()
    {
       $user = auth()->user()->permissions;
       dd($user);

        if (auth()->user()->hasPermissionTo('orers.all')){
        $orders = Order::all(); }

        if (auth()->user()->hasPermissionTo('orers.user')){
        $orders = auth()->user()->orders; }


        return response()->json([
            'orders' => $orders,
            'status' => 'success'
        ] , 200);
    }

    

    public function store(Request $request)
    {
        $request->validate([
           'products'=>'required',
           'description' => 'sometimes',
        ]);

        $order = Order::create([
            'user_id'=>$request->user()->id,
            'description' => $request->description
        ]);

        $products = $request->products;

        $productSync = [];

        foreach($products as $product)
        {
            $productSync[] = $product;
        }

        $order->products()->attach($productSync);

        return response()->json([
            'order' => $order ,
            'status' => 'Created Successfully'
        ] , 201);
    }

    

    public function show(string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Order Not Found',
                'status' => 'Not Found'
            ] , 404);
        }

        return response()->json([
            'order' => $order ,
            'status' => 'success'
        ] , 200);
    }

    

    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'sometimes',
            'products'=>'sometimes',
            'description' => 'sometimes',
         ]);

         $order = Order::find($id);

         if (!$order) {
            return response()->json([
             'message' => 'order not found',
             'status'=> 'Not Found'
            ] , 404);
         }

         $order->update($request->toArray());

         if($request->products) {
            $products = $request->products;
            $productSync = [];
            foreach($products as $product)
            {
               $productSync[] = $product;
            }

            $order->products()->attach($productSync);
         }

         return response()->json([
            'order'=>$order,
            'status'=> 'success'
         ] , 200);
    }

    

    public function destroy(string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
             'message' => 'order not found',
             'status'=> 'Not Found'
            ] , 404);
         }

         $order->delete();
         return response()->json([
            'message' => 'order destroy successfully',
            'status' => 'success'
         ] , 200);
    }
}
