<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwitchController;
use App\Http\Controllers\VoteController;

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

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/signup', [AuthController::class, 'signUp']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/getTopVoted', [Votecontroller::class, 'getTopVoted']);
Route::post('/voteStreamer', [VoteController::class, 'voteStreamer']);

Route::get('/getTopStreams', [TwitchController::class, 'getTopStreams']);
Route::get('/getTopGames', [TwitchController::class, 'getTopGames']);
Route::post('/getStreamer', [TwitchController::class, 'getStreamer']);