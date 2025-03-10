<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Order;

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




Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});



Route::group([
    'middleware'=>'auth:api'
],function(){

});
Route::group([
    // 'middleware'=>'auth:api'
],function(){

    Route::apiResource('brand',BrandController::class);
    
    Route::apiResource('category',CategoryController::class)->only([
        'index',
        'show',
        'store',
        'destroy',
    ]);

    Route::post('category/update/{id}',[CategoryController::class,'update']);

    Route::apiResource('location',LocationController::class)->only([
        'index',
        'store',
        'update',
        'destroy'
    ]);


    Route::apiResource('product',ProductController::class)->except('update');
    Route::post('product/update/{id}',[ProductController::class,'update']);


    Route::group([
        'prefix' => 'order'  
    ],function(){
        Route::get('/',[OrderController::class,'index']);
        Route::post('/',[OrderController::class,'store']);
        Route::get('/{id}',[OrderController::class,'show']);
        Route::get('/get_order_items/{id}',[OrderController::class,'get_order_items']);
        Route::get('/get_user_orders/{user_id}',[OrderController::class,'get_user_orders']);
        Route::post('/change_order_status/{id}',[OrderController::class,'change_order_status']);

    });


});