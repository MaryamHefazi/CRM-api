<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
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

    
    public function create(AssignRoleRequest $request)
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

    

    public function store(StoreRoleRequest $request)
    {
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

    
    public function update(UpdateRoleRequest $request, string $id)
    {
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
