<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'products' => $products,
            'status' => 'success',
        ] , 200);
    }

    
    public function store(StoreProductRequest $request)
    {
        $addedBy = auth()->user()->id;
    
        $porduct = Product::create([
            'productName'=>$request->productName,
            'number'=>$request->number,
            'price'=>$request->price,
            'color'=>$request->color,
            'addedBy'=>$addedBy,
            'description'=>$request->description,
        ]);

        $categories = $request->categories;

        $categorySync = [];

        foreach($categories as $category)
        {
            $categorySync[] = $category;
        }

        $porduct->categories()->attach($categorySync);

        return response()->json([
           'product' => $porduct,
           'status' => 'Created Successfully'
       ] , 201);
    }

    

    public function show(string $id)
    {
        $porduct = Product::find($id);

        if (!$porduct) {
             return response()->json([
                'message' => 'porduct not found',
                'status' => 'Not Found'
             ] , 404);
        }
        return response()->json([
            'porduct'=>$porduct,
            'status'=>'success'

        ] , 200);
    }

   

    
    public function update(UpdateProductRequest $request, string $id)
    {
        $userLoggedIn = auth()->user();
        $porduct = Product::find($id);
        
        if(!$porduct){
            return response()->json([
                'message' => 'porduct not found',
                'status'=> 'Not Found'
            ] , 404); 
        }

        elseif($userLoggedIn->hasPermissionTo('products.update') || ($userLoggedIn->hasPermissionTo('products.update.seler') && $userLoggedIn->id == $porduct->addedBy)){
            
            $porduct->update($request->toArray());

            if($request->categories)
            {
                $categories = $request->categories;
                $categorySync = [];
                foreach($categories as $category)
                {
                $categorySync[] = $category;
                }
                $porduct->categories()->attach($categorySync);
            }
            
            return response()->json([
                'porduct'=>$porduct,
                'status'=> 'success'
            ] , 200);
        }
   }


    public function destroy(string $id)
    {
        $userLoggedIn = auth()->user();
        $porduct = Product::find($id);
        
        if(!$porduct){
            return response()->json([
                'message' => 'porduct not found',
                'status'=> 'Not Found'
            ] , 404); 
        }

        elseif($userLoggedIn->hasPermissionTo('products.update') || ($userLoggedIn->hasPermissionTo('products.update.seler') && $userLoggedIn->id == $porduct->addedBy)){

         $porduct->delete();
         return response()->json([
            'message' => 'porduct destroy successfully',
            'status' => 'success'
         ] , 200);
        }
    }
}