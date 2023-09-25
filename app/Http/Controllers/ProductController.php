<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'products' => $products,
            'status' => 'success',
        ] , 200);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'productName'=>'required',
            'categories'=>'required',
            'number'=>'required|numeric',
            'price'=>'required|numeric',
            'color'=>'required',
        ]);

        $porduct = Product::create($request->toArray());

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

   

    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'productName'=>'sometimes',
            'categories'=>'sometimes',
            'number'=>'sometimes|numeric',
            'price'=>'sometimes|numeric',
            'color'=>'sometimes'
        ]);

        $porduct = Product::find($id);

        if (!$porduct) {
           return response()->json([
            'message' => 'porduct not found',
            'status'=> 'Not Found'
           ] , 404);
        }

        $porduct->update($request->toArray());

        if($request->categories)
        {
            $categories = $request->categories;
            $categorySync = [];
            foreach($categories as $category)
            {
               $categorySync[] = $category;
            }
            $porduct->categoeires()->attach($categorySync);
        }
        
        return response()->json([
            'porduct'=>$porduct,
            'status'=> 'success'
         ] , 200);
    }



    public function destroy(string $id)
    {
        $porduct = Product::find($id);

        if (!$porduct) {
            return response()->json([
             'message' => 'porduct not found',
             'status'=> 'Not Found'
            ] , 404);
         }

         $porduct->delete();
         return response()->json([
            'message' => 'porduct destroy successfully',
            'status' => 'success'
         ] , 200);
    }
}
