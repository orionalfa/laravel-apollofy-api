<?php

use App\Http\Controllers\GlobalPlayController;
use App\Models\GlobalPlay;
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

Route::get('/global-plays', [GlobalPlayController::class, 'getAllGlobalPlays']);

Route::post('/global-plays', [GlobalPlayController::class, 'storeGlobalPlay']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
