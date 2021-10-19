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

Route::post('/global-plays', [GlobalPlayController::class, 'storeGlobalPlay']);
Route::get('/global-plays', [GlobalPlayController::class, 'getAllGlobalPlays']);
Route::get('/last-global-activity', [GlobalPlayController::class, 'getLastGlobalActivity']);
Route::get('/yesterday-global-activity-by-hours', [GlobalPlayController::class, 'getYesterdayGlobalActivityByHours']);
Route::get('/yesterday-activity-by-hours/{owner_id}', [GlobalPlayController::class, 'getYesterdayActivityByHours']);
Route::get('/total-plays/{owner_id}', [GlobalPlayController::class, 'getTotalPlaysByOwner']);
Route::get('/last-hour-plays/{owner_id}', [GlobalPlayController::class, 'getLastHourPlaysByOwner']);
Route::get('/last-24h-total-plays/{owner_id}', [GlobalPlayController::class, 'getLast24HoursPlaysByOwner']);
Route::get('/last-24h-most-played', [GlobalPlayController::class, 'getLast24HMostPlayedGlobal']);
Route::get('/last-24h-most-played/{owner_id}', [GlobalPlayController::class, 'getLast24HMostPlayedTracksByOwner']);
Route::get('/week-most-played', [GlobalPlayController::class, 'getLastWeekMostPlayedGlobal']);
Route::get('/week-most-played/{owner_id}', [GlobalPlayController::class, 'getLastWeekMostPlayedTracksByOwner']);
Route::get('/week-most-played-usr/{user_id}', [GlobalPlayController::class, 'getLastWeekMostPlayedTracksByUser']);
Route::get('/week-top-5-random', [GlobalPlayController::class, 'getWeekTop5Random']);
Route::get('/month-top-5-random', [GlobalPlayController::class, 'getMonthTop5Random']);



Route::post('/related-plays', [RelatedPlayController::class, 'storeRelatedPlay']);
Route::get('/related-plays', [RelatedPlayController::class, 'getAllRelatedPlays']);
Route::get('/most-related-tracks', [RelatedPlayController::class, 'getMostRelatedTracks']);
Route::get('/most-related-tracks/{track_id}', [RelatedPlayController::class, 'getMostRelatedTracksById']);
Route::get('/random-related-track/{track_id}', [RelatedPlayController::class, 'getRandomRelatedTrackById']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
