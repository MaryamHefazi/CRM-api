<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Spatie\Permission\Models\Permission;
use App\jobs\StoreOrderJob;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except([]);
    }

    
    public function index()
    {
        $user = auth()->user();

        if ($user->hasPermissionTo('orders.all')){
        $orders = Order::all(); }

        elseif ($user->hasPermissionTo('orders.all.user')){
        $orders = auth()->user()->orders; }

        return response()->json([
            'orders' => $orders,
            'status' => 'success'
        ] , 200);
    }

    

    public function store(StoreOrderRequest $request)
    {
        $userLoggedIn = auth()->user();

        if($userLoggedIn->hasPermissionTo('orders.store')){
            $user_id = $request->user_id;
        }
        elseif($userLoggedIn->hasPermissionTo('orders.store.user')){
            $user_id = $request->user()->id;
        }

        $order = Order::create([
            'user_id'=>$user_id,
            'description' => $request->description
        ]);

        $products = $request->products;
        $productSync = [];
        foreach($products as $product)
        {
            $productSync[] = $product;
            $product = Product::find($product);
            $product->number-=1;
        }

        $order->products()->attach($productSync);

        StoreOrderJob::dispatch(auth()->user()->email);

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

    

    public function update(UpdateOrderRequest $request, string $id)
    {
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
