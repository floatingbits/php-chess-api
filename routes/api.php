<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//Route::resource('/match');
Route::resource('/v1/matches', v1\MatchController::class, ['only' => ['index', 'store', 'destroy']]);
Route::resource('/v1/matches.move', v1\MatchMoveController::class, ['only' => ['store']]);
Route::get('/v1/matches/{matchId}/bestmove', 'v1\MatchMoveController@bestMove');

