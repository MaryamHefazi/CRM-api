<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOpportunityRequest;
use App\Http\Requests\UpdateOpportunityRequest;
use App\Models\Opportunity;
use Spatie\Permission\Models\Permission;
use App\jobs\StoreOpportunityJob;

class OpportunityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    
    public function index()
    {
        $user = auth()->user();
    
        if ($user->hasPermissionTo('opportunities.all')){
        $opportunities = Opportunity::all(); }

        elseif ($user->hasPermissionTo('opportunities.all.user')){
        $opportunities = auth()->user()->Opportunities; }

        return response()->json([
            'opportunities' => $opportunities ,
            'status' => 'success'
        ] , 200);
    }

    
   
    public function store(StoreOpportunityRequest $request)
    {
        $userLoggedIn = auth()->user();

        if($userLoggedIn->hasPermissionTo('opportunities.store')){
            $user_id = $request->user_id;
        }
        elseif($userLoggedIn->hasPermissionTo('opportunities.store.user')){
            $user_id = $request->user()->id;
        }

        $opportunity = Opportunity::create([
            'user_id' => $user_id ,
            'number' => $request->number ,
            'color' => $request->color ,
            'price' => $request->price ,
            'total_price' => $request->total_price ,
            'status' => $request->status ,
        ]);

        $products = $request->products;

        $productSync = [];

        foreach ($products as $product)
        {
            $productSync[] = $product;
        }

        $opportunity->products()->attach($productSync);
        StoreOpportunityJob::dispatch();
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

    

    public function update(UpdateOpportunityRequest $request, string $id)
    {
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
