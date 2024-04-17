<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;

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

Route::post('/login', [UserController::class, 'login'])->middleware('validate.user');
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/info', [UserController::class, 'info']);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('invoice', InvoiceController::class);
    Route::post('/categoryDeleteAll', [CategoryController::class, 'delete']);
    Route::get('/categoryDetail/{id}', [CategoryController::class, 'categoryDetail']);
    Route::post('/productDeleteAll', [ProductController::class, 'delete']);
    Route::get('/invoiceDetail/{id}', [InvoiceController::class, 'invoiceDetail']);
    Route::post('/invoiceDeleteAll', [InvoiceController::class, 'delete']);
});
