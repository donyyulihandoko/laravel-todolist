<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

Route::get('/', [HomeController::class, 'index']);

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'login')->middleware(['guest']);
    Route::post('/login', 'doLogin')->middleware(['guest']);
    Route::post('/logout', 'doLogout')->middleware(['member']);
});

Route::controller(TodolistController::class)
    ->middleware(['member'])
    ->group(function () {
        Route::get('/todolist', 'todolist');
        Route::post('/todolist', 'addTodo');
        Route::post('/todolist/{id}/delete', 'removeTodo');
    });

Route::fallback(function () {
    return "Halaman Tidak Tersedia";
});
