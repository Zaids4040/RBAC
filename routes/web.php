<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', function(){
    return view('master');
})->name('dashboard')->middleware('validatemw');


Route::get('/login',[MainController::class, 'login']);
Route::post('/login',[MainController::class, 'validate'])->name('login');

Route::get('/logout',[MainController::class,'logout'])->name('logout');


