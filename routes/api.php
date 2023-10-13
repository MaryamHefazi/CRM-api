<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
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

    Route::get('/category' , [CategoryController::class , 'index'])->middleware('permission:categories.all');
    Route::post('/category' , [CategoryController::class , 'store'])->middleware('permission:categories.store');
    Route::get('/category/{category}' , [CategoryController::class , 'show'])->middleware('permission:categories.show');
    Route::put('/category/{category}' , [CategoryController::class , 'update'])->middleware('permission:categories.update');
    Route::delete('/category/{category}' , [CategoryController::class , 'destroy'])->middleware('permission:categories.delete');


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Users routes

    Route::get('/user' , [UserController::class , 'index'])->middleware('permission:users.all|users.all.user');
    Route::post('/user' , [UserController::class , 'store'])->middleware('permission:users.store');
    Route::get('/user/{user}' , [UserController::class , 'show'])->middleware('permission:users.show');
    Route::put('/user/{user}' , [UserController::class , 'update'])->middleware('permission:users.update|users.update.user');
    Route::delete('/user/{user}' , [UserController::class , 'destroy'])->middleware('permission:users.delete|users.delete.user');

/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Authentication routes

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/email', [AuthController::class, 'sendEmail']);


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Factures routes

    Route::get('/facture' , [FactureController::class , 'index'])->middleware('permission:factures.all|factures.all.user');
    Route::post('/facture' , [FactureController::class , 'store'])->middleware('permission:factures.store');;
    Route::get('/facture/{facture}' , [FactureController::class , 'show'])->middleware('permission:factures.show');;
    Route::put('/facture/{facture}' , [FactureController::class , 'update'])->middleware('permission:factures.update');;
    Route::delete('/facture/{facture}' , [FactureController::class , 'destroy'])->middleware('permission:factures.delete');;


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Opportunities routes

    Route::get('/opportunity' , [OpportunityController::class , 'index'])->middleware('permission:opportunities.all|opportunities.all.user');
    Route::post('/opportunity' , [OpportunityController::class , 'store'])->middleware('permission:opportunities.store|opportunity.store.user');
    Route::get('/opportunity/{opportunity}' , [OpportunityController::class , 'show'])->middleware('permission:opportunities.show');
    Route::put('/opportunity/{opportunity}' , [OpportunityController::class , 'update'])->middleware('permission:opportunities.update');
    Route::delete('/opportunity/{opportunity}' , [OpportunityController::class , 'destroy'])->middleware('permission:opportunities.delete');


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Order routes

    Route::get('/order' , [OrderController::class , 'index'])->middleware('permission:orders.all|orders.all.user');
    Route::post('/order' , [OrderController::class , 'store'])->middleware('permission:orders.store|orders.store.user');
    Route::get('/order/{order}' , [OrderController::class , 'show'])->middleware('permission:orders.show');
    Route::put('/order/{order}' , [OrderController::class , 'update'])->middleware('permission:orders.update');
    Route::delete('/order/{order}' , [OrderController::class , 'destroy'])->middleware('permission:orders.delete');


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Product routes

    Route::get('/product' , [ProductController::class , 'index'])->middleware('permission:products.all');
    Route::post('/product' , [ProductController::class , 'store'])->middleware('permission:products.store|products.store.seler');
    Route::get('/product/{product}' , [ProductController::class , 'show'])->middleware('permission:products.show');
    Route::put('/product/{product}' , [ProductController::class , 'update'])->middleware('permission:products.update|products.update.seler');
    Route::delete('/product/{product}' , [ProductController::class , 'destroy'])->middleware('permission:products.delete|products.delete.seler');


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/

//Role routes

    Route::get('/role' , [RoleController::class , 'index'])->middleware('permission:roles.all');
    Route::post('/role' , [RoleController::class , 'store'])->middleware('permission:roles.store');
    Route::get('/role/{role}' , [RoleController::class , 'show'])->middleware('permission:roles.show');
    Route::put('/role/{role}' , [RoleController::class , 'update'])->middleware('permission:roles.update');
    Route::delete('/role/{role}' , [RoleController::class , 'destroy'])->middleware('permission:roles.delete');
    Route::post('/assign', [RoleController::class, 'create']);


/* ---------------------------------------------------------------------------------------------------------------------------------------------*/



