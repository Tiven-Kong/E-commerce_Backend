<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//Category

Route::get('/category', [CategoryController::class, 'index']);
Route::post('/createCategory', [CategoryController::class, 'store']);
Route::put('/update/{id}', [CategoryController::class, 'update']);
Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
});

