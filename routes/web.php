<?php

use App\Events\ScoreBoardEvent;
use App\Events\testingEvent;
use App\Http\Controllers\ScoreBoardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
