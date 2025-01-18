<?php

use App\Events\ScoreBoardEvent;
use App\Events\testingEvent;
use App\Http\Controllers\ScoreBoardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $teams = "Team A vs Team B";
    $score = "3 - 2"; // Example score
    $status = "In Progress";


    broadcast(new ScoreBoardEvent($teams, $score, $status));
    return 'Done';
});

Route::get('/test-t', function () {
    $teams = "Team A vs Team B";
    $score = "4 - 2"; // Example score
    $status = "In Progress";


    broadcast(new ScoreBoardEvent($teams, $score, $status));
    return 'Done';
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ensure only authenticated users can access these routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/scoreboard/update', [ScoreBoardController::class, 'show'])->name('scoreboard.show');
    Route::get('/scoreboard/edit', [ScoreBoardController::class, 'edit'])->name('scoreboard.edit');
    Route::post('/scoreboard/update', [ScoreBoardController::class, 'update'])->name('scoreboard.update');
});
