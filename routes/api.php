<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('customer' , CustomerController::class);
Route::apiResource('product' , ProductController::class);
Route::apiResource('order' , OrderController::class);
Route::apiResource('facture' , FuctureController::class);
Route::apiResource('opportunity' , OpportunityController::class);
Route::apiResource('category' , CategoryController::class);

Route::apiResource('role' , RoleController::class);
Route::post('/assign' , [RoleController::class , 'create']);


Route::post('/register' ,[ UserController::class , 'register']);
Route::post('/login' ,[ UserController::class , 'login']);
Route::middleware('auth:sanctum')->post('/logout' ,[ UserController::class , 'logout']);
Route::get('/email' ,[ UserController::class , 'sendEmail']);
