<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }


    public function index()
    {
        $reles = Role::all();
        return response()->json([
            'roles' => $reles,
            'status' => 'success',
        ] , 200);
    }

    
    public function create(Request $request)
    {
        $role = Role::findById($request->role_id);

        $permissions = $request->permissions_id;
        $permissionSync = [];
         foreach($permissions as $permission)
         {
             $permissionAssign = Permission::findById($permission);
             $permissionSync[] = $permissionAssign;
         }

        $role->givePermissionTo($permissionSync);

        return response()->json([
            'role' => $role,
            'status' => 'success',
        ] , 200);
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Role::create($request->toArray());
        return Response()->json([
            'role' => $role,
            'status' => 'create successfully',
        ] , 201);
    }

    

    public function show(string $id)
    {
        $role = Role::findById($id);
        if (!$role){
            return Response()->json([
                'message' => 'role not found',
                'status'=> 'Not Found'
            ] , 404);
        }

        return Response()->json([
            'role' => $role ,
            'status' => 'success',
        ] , 200);
    }

    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'sometimes',
        ]);

        $role = Role::findById($id);

        if (!$role){
            return Response()->json([
                'message' => 'role not found',
                'status'=> 'Not Found'
            ] , 404);
        }

        $role->update($request->toArray());
        return Response()->json([
            'role' => $role ,
            'status' => 'success',
        ] , 200);
    }

    
    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role){
            return Response()->json([
                'message' => 'role not found',
                'status'=> 'Not Found'
            ] , 404);
        }

        $role->delete();
        return Response()->json([
            'message' => 'role destroy successfully',
            'status'=> 'success'
        ] , 200);

    }
}
