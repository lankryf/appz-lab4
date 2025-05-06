<?php

use Bubblegum\Routes\Route;

// use Bubblegum controllers down here
use App\Controllers\GiftController;
use App\Controllers\QuestRoomController;
use App\Controllers\RegisterController;
use App\Controllers\BookController;

Route::get('/gifts', GiftController::class);
Route::post('/gifts', GiftController::class);

Route::get('/rooms', QuestRoomController::class);
Route::post('/rooms', QuestRoomController::class);

Route::post('/register', RegisterController::class);

Route::post('/book', BookController::class);
