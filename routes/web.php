<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Controller::class, 'users']);

Route::get('/register', [App\Http\Controllers\Controller::class, 'registerPage']);

Route::get('/login', [App\Http\Controllers\Controller::class, 'login']);

Route::get('/profile', [App\Http\Controllers\Controller::class, 'page_profile']);

Route::get('/status', [App\Http\Controllers\Controller::class, 'changeStatus']);

Route::get('/media', [App\Http\Controllers\Controller::class, 'media']);

Route::get('/create', [App\Http\Controllers\Controller::class, 'createUser']);

Route::get('/edit', [App\Http\Controllers\Controller::class, 'editUser']);

Route::get('/security', [App\Http\Controllers\Controller::class, 'security']);

Route::post('/checkregister', [App\Http\Controllers\UserController::class, 'register']);

Route::post('/loginUser', [App\Http\Controllers\UserController::class, 'loginUser']);
