<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::orderBy("id","desc")->paginate(10);
        return response()->json(['shops' => $shops]);
    }

    public function store(Request $request)
    {
        $shop = Shop::create($request->toArray());

        $shop->locations()->create([
            'lng' => $request->input('lng'),
            'lat'=> $request->input('lat'),
        ]);

        return response()->json(['ShopInfo'=> $shop]);
    }

    public function show(Shop $shop)
    {
        // dd($shop->locations);
         return response()->json(['shop'=> $shop]);
    }

    public function update(Request $request, Shop $shop)
    {
        $shop->update($request->all());
        return response()->json(['shop'=> $shop] , 200);
    }

    public function destroy(Request $request, Shop $shop)
    {
        $shop->delete();
        return response()->json(['message'=> $shop->shopName .' deleted successfully'] , 200);
    }
}
