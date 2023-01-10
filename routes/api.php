<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('customer')->group(function () {
    Route::post('login', [\App\Http\Controllers\CustomerController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\CustomerController::class, 'register']);
});

Route::prefix('brands')->group(function () {
    Route::get('', [\App\Http\Controllers\BranchController::class, 'index']);
    Route::post('', [\App\Http\Controllers\BranchController::class, 'store']);
});

Route::prefix('categories')->group(function () {
    Route::get('', [\App\Http\Controllers\CategoryController::class, 'index']);
});

Route::prefix('cars')->group(function () {
    Route::get('', [\App\Http\Controllers\CarController::class, 'index']);
    Route::post('', [\App\Http\Controllers\CarController::class, 'store']);
    Route::get('get-first-car/',[\App\Http\Controllers\CarController::class, 'getFirstCar']);
    Route::get('{id}', [\App\Http\Controllers\CarController::class, 'show']);
    Route::post('{id}', [\App\Http\Controllers\CarController::class, 'edit']);
});

Route::prefix('bills')->group(function () {
    Route::get('', [\App\Http\Controllers\BillController::class, 'index']);
    Route::get('{id}', [\App\Http\Controllers\BillController::class, 'show']);
    Route::post('', [\App\Http\Controllers\BillController::class, 'store']);
    Route::post('{id}', [\App\Http\Controllers\BillController::class, 'update']);

});

Route::prefix('employee')->group(function () {
    Route::post('login', [\App\Http\Controllers\EmployeeController::class, 'login']);
});

Route::prefix('statistical')->group(function () {
    Route::get('summary', [\App\Http\Controllers\BillController::class, 'summary']);
    Route::get('recent-bill', [\App\Http\Controllers\BillController::class, 'recentBill']);
    Route::get('revenue-car', [\App\Http\Controllers\BillController::class, 'revenueByCar']);
    Route::get('revenue-month', [\App\Http\Controllers\BillController::class, 'revenueByMonth']);
});
