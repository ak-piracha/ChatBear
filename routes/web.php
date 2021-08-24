<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chatroom/{id}', function ($id) {
    
    return view('chatroom')->with(['id' => $id]);
})->middleware(['auth'])->name('chatroom');

Route::get('/chatlist', function () {
    return view('chatlist');
})->middleware(['auth'])->name('chatlist');

Route::get('users', [UserController::class, 'index']);

Route::get('status', [UserController::class, 'status']);

Route::get('live', [UserController::class, 'liveStatusPage']);

Route::get('live-status/{id}', [UserController::class, 'liveStatus']);

require __DIR__.'/auth.php';
