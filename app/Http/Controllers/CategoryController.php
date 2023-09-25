<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    

    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'categories' => $categories , 
            'status' => 'success'
        ] , 200);
    }

    

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required'
        ]);

        $category = Category::create($request->toArray());
        return response()->json([
            'category' => $category , 
            'status' => 'create successfully'
        ] , 201);
    }

    

    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'category Not Found',
                'status' => 'Not Found'
            ] , 404);
        }

        return response()->json([
            'category' => $category ,
            'status' => 'success'
        ] , 200);
    }

    

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'category Not Found',
                'status' => 'Not Found'
            ] , 404);
        }

        $category->update($request->toArray());

        return response()->json([
            'category' => $category ,
            'status' => 'success'
        ] , 200);


    }

    

    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'category Not Found',
                'status' => 'Not Found'
            ] , 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'category deleted successfully' ,
            'status' => 'success'
        ] , 200);
    }
}
