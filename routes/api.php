<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
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

/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Category routes 

    Route::get('/category' , [CategoryController::class , 'index']);
    Route::post('/category' , [CategoryController::class , 'store']);
    Route::get('/category/{category}' , [CategoryController::class , 'show']);
    Route::patch('/category/{category}' , [CategoryController::class , 'update']);
    Route::delete('/category/{category}' , [CategoryController::class , 'destroy']);


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Users routes

    Route::get('/user' , [UserController::class , 'index']);
    Route::post('/user' , [UserController::class , 'store']);
    Route::get('/user/{user}' , [UserController::class , 'show']);
    Route::patch('/user/{user}' , [UserController::class , 'update']);
    Route::delete('/user/{user}' , [UserController::class , 'destroy']);

//Authentication

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/email', [UserController::class, 'sendEmail']);


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Factures routes

    Route::get('/facture' , [FactureController::class , 'index']);
    Route::post('/facture' , [FactureController::class , 'store']);
    Route::get('/facture/{facture}' , [FactureController::class , 'show']);
    Route::patch('/facture/{facture}' , [FactureController::class , 'update']);
    Route::delete('/facture/{facture}' , [FactureController::class , 'destroy']);


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Opportunities routes

    Route::get('/opportunity' , [OpportunityController::class , 'index']);
    Route::post('/opportunity' , [OpportunityController::class , 'store']);
    Route::get('/opportunity/{opportunity}' , [OpportunityController::class , 'show']);
    Route::patch('/opportunity/{opportunity}' , [OpportunityController::class , 'update']);
    Route::delete('/opportunity/{opportunity}' , [OpportunityController::class , 'destroy']);


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Order routes

    Route::get('/order' , [OrderController::class , 'index']);
    Route::post('/order' , [OrderController::class , 'store']);
    Route::get('/order/{order}' , [OrderController::class , 'show']);
    Route::patch('/order/{order}' , [OrderController::class , 'update']);
    Route::delete('/order/{order}' , [OrderController::class , 'delete']);


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Product routes

    Route::get('/product' , [ProductController::class , 'index']);
    Route::post('/product' , [ProductController::class , 'store']);
    Route::get('/product/{product}' , [ProductController::class , 'show']);
    Route::patch('/product/{product}' , [ProductController::class , 'update']);
    Route::delete('/product/{product}' , [ProductController::class , 'delete']);


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Role routes
Route::group(['middleware'=>'role:admin'] , function(){

    Route::get('/role' , [RoleController::class , 'index']);
    Route::post('/role' , [RoleController::class , 'store']);
    Route::get('/role/{role}' , [RoleController::class , 'show']);
    Route::patch('/role/{role}' , [RoleController::class , 'update']);
    Route::delete('/role/{role}' , [RoleController::class , 'delete']);
    Route::post('/assign', [RoleController::class, 'create']);
});

/* ---------------------------------------------------------------------------------------------------------------------------------------------*/



