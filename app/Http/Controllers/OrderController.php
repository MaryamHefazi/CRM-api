<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Spatie\Permission\Models\Permission;
use App\jobs\StoreOrderJob;
use GuzzleHttp\Client;

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
            'sendType'=>$request->sendType,
            'vehicleType'=> $request->vehicleType,
            'address'=> $request->address,
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

    public function cost($id)
    {
        $client = new Client();

        $data = $client->post('https://graphhopper.com/api/1/route?key=54df6170-baa2-4f1e-86f4-9f9a90429edf' , [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'points' =>[
                    [11.539421, 48.118477],
                    [11.559023, 48.12228],
                ]
            ]
        ]);

        // dd($data);

        // return response()->json(json_decode($data->getBody()->getContents(), true));

        $result = json_decode($data->getBody()->getContents());

        $distance = $result->paths[0]->distance;
        $distance_KM = $distance/1000;

        $time = $result->paths[0]->time;
        $time_H = $time/60000;
        
        return [
            'dKM'=> $distance_KM,
            'd'=> $distance,
            'time'=> $time,
            'timeHH'=> $time_H,
        ];
    }
}
