<?php

use App\Http\Controllers\GlobalPlayController;
use App\Http\Controllers\RelatedPlayController;
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

Route::get('/related-plays', [RelatedPlayController::class, 'getAllRelatedPlays']);
Route::post('/related-plays', [RelatedPlayController::class, 'storeRelatedPlay']);

Route::get('/last-global-activity', [GlobalPlayController::class, 'getLastGlobalActivity']);

Route::get('/yesterday-global-activity-by-hours', [GlobalPlayController::class, 'getYesterdayGlobalActivityByHours']);
// Route::get('/yesterday-global-activity-by-hours/:currentuser', [GlobalPlayController::class, 'getYesterdayGlobalActivityByHours']);

Route::get('/total-plays-by-owner/{owner_id}', [GlobalPlayController::class, 'getTotalPlaysByOwner']);

Route::get('/last-hour-plays-by-owner/{owner_id}', [GlobalPlayController::class, 'getLastHourPlaysByOwner']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
