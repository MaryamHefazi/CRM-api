<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class FactureController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except([]);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasPermissionTo('factures.all')){
        $factures = Facture::all(); }

        elseif ($user->hasPermissionTo('factures.all.user')){
        $factures = auth()->user()->factures; }

        return response()->json([
            'factures' => $factures,
            'status' => 'success'
        ] , 200);

    }

    
    public function create(Request $request)
    {
        //Getting the order ID and creating an invoice related to it 

        $order = Order::find($request->order_id);
        $user_id = $order->user_id;

        $user = User::find($user_id);
        
        $products = $order->products;

        $totalPrice = 0;
        foreach($products as $product)
        {
            $totalPrice += $product->price;
        }

        $facture = Facture::create([
            'user_id'=> $user->id,
            'order_id'=> $order->id,
            'totalPrice'=> $totalPrice,
            'paymentType'=> $request->paymentType,
            'status'=> $request->status,
        ]);


        return response()->json([
            'facture'=> $facture , 
            'products'=>$products,
            'status'=> 'create facture successfully',
        ] ,201);
    }

    
    public function store(Request $request)
    {
        
    }

    
    public function show(string $id)
    {
        $facture = Facture::find($id);

        if (!$facture) {
            return response()->json([
                'message' => 'facture Not Found',
                'status' => 'Not Found'
            ] , 404);
        }

        return response()->json([
            'facture' => $facture ,
            'status' => 'success'
        ] , 200);
    }


    
    public function update(Request $request, string $id)
    {
        $facture = Facture::find($id);

        if (!$facture) {
            return response()->json([
             'message' => 'factures not found',
             'status'=> 'Not Found'
            ] , 404);
         }

         $facture->update($request->toArray());
         
         return response()->json([
            'facture'=> $facture ,
            'message' => 'factures updated successfully',
            'status' => 'success'
         ] , 200);
   }
    
    public function destroy(string $id)
    {
        $factures = Facture::find($id);

        if (!$factures) {
            return response()->json([
             'message' => 'factures not found',
             'status'=> 'Not Found'
            ] , 404);
         }

         $factures->delete();
         return response()->json([
            'message' => 'factures destroy successfully',
            'status' => 'success'
         ] , 200);
    }
}

