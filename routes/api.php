<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::post('/fingerprint-test', [MainController::class, 'attendence']);
