<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/place-order', [ItemsController::class, 'placeItemOrder'])->middleware('auth:api');
Route::get('/items', [ItemsController::class, 'getAllItems'])->middleware('auth:api');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password-reset', [AuthController::class, 'sendResetLinkEmail']);
Route::post('/create-user', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/create-order', [OrderController::class, 'store']);
Route::middleware('auth:sanctum')->get('/get-orders', [OrderController::class, 'getUserOrders']);
Route::middleware('auth:sanctum')->get('/items', [ItemsController::class, 'getAllItems']);
Route::middleware('auth:sanctum')->post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);
Route::middleware('auth:sanctum')->get('/get-user', [UserController::class, 'getUserDetails']);
Route::middleware('auth:sanctum')->post('/update-user', [UserController::class, 'updateUser']);
Route::middleware('auth:sanctum')->get('/get-predictions', [ItemsController::class, 'getPredictions']);

