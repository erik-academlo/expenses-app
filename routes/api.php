<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
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

Route::prefix('v1')->middleware(['api','auth:sanctum'])->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('categories', CategoryController::class)->only(['index']);

    Route::post('expenses/import', [ExpenseController::class, 'storeUsingExcel']);
    Route::apiResource('expenses', ExpenseController::class)->only(['index', 'store', 'update']);
});
