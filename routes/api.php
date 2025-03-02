<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//Category

Route::get('/category', [CategoryController::class, 'index']);
Route::post('/createCategory', [CategoryController::class, 'store']);
Route::put('/updateCategory/{id}', [CategoryController::class, 'update']);
Route::delete('/deleteCategory/{id}', [CategoryController::class, 'destroy']);


 
//Product 

Route::get('/product' , [ProductController::class , 'index']);
Route::post('/createProduct' , [ProductController::class , 'store']);
Route::put('/updateProduct/{id}' , [ProductController::class , 'update']);
Route::delete('deleteProduct/{id}'  , [ProductController::class , 'destroy']);


///

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
});

