<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $user->locations()->create([
            'lng' => $request->input('lng'),
            'lat'=> $request->input('lat'),
        ]);

        return response()->json([
            'status'=> 'success'
        ]);
    }
}
