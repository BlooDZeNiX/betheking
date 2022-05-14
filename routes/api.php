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
Route::post('/editUserImage', [AuthController::class, 'editUserImage']);
Route::post('/editUserPassword', [AuthController::class, 'editUserPassword']);
Route::post('/verifyEmail', [AuthController::class, 'verifyEmail']);
Route::post('/editUserData', [AuthController::class, 'editUserData']);
Route::post('/deleteUserData', [AuthController::class, 'deleteUserData']);
Route::post('/getUserById', [AuthController::class, 'getUserById']);
Route::get('/getUsers', [AuthController::class, 'getUsers']);
Route::get('/getTodayUsers', [AuthController::class, 'getTodayUsers']);
Route::get('/image/{filename}', [AuthController::class, 'image']);

Route::get('/TopVoted', [VoteController::class, 'getTopVoted']);
Route::get('/getTodayVotes', [VoteController::class, 'getTodayVotes']);
Route::post('/userVotes', [VoteController:: class, 'getUserVotes']);
Route::post('/voteStreamer', [VoteController::class, 'voteStreamer']);
Route::post('/voteGame', [VoteController::class, 'voteGame']);

Route::get('/getTopStreams', [TwitchController::class, 'getTopStreams']);
Route::get('/getTopGames', [TwitchController::class, 'getTopGames']);
Route::get('/getStreamers', [TwitchController::class, 'getStreamers']);
Route::post('/setStream', [TwitchController::class, 'setStream']);
Route::post('/getStreamer', [TwitchController::class, 'getStreamer']);
Route::post('/setStreamer', [TwitchController::class, 'setStreamer']);
Route::post('/deleteStreamer', [TwitchController::class, 'deleteStreamer']);
Route::post('/getGame', [TwitchController::class, 'getGame']);
Route::post('/setGame', [TwitchController::class, 'setGame']);
Route::get('/getGames', [TwitchController::class, 'getGames']);
Route::post('/deleteGame', [TwitchController::class, 'deleteGame']);
