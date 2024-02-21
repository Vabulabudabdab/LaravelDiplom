<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Controller::class, 'users'])->middleware('auth');

Route::get('/register', [App\Http\Controllers\Controller::class, 'registerPage']);

Route::get('/login', [App\Http\Controllers\Controller::class, 'login']);

Route::get('/profile', [App\Http\Controllers\Controller::class, 'page_profile']);

Route::get('/status/{id}', [App\Http\Controllers\Controller::class, 'changeStatus']);

Route::get('/media/{id}', [App\Http\Controllers\Controller::class, 'media']);

Route::get('/create', [App\Http\Controllers\Controller::class, 'createUser']);

Route::get('/edit', [App\Http\Controllers\Controller::class, 'editUser']);

Route::get('/security/{id}', [App\Http\Controllers\Controller::class, 'security']);

Route::post('/checkregister', [App\Http\Controllers\UserController::class, 'register']);

Route::post('/loginUser', [App\Http\Controllers\UserController::class, 'loginUser']);

Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/delete{id}', [App\Http\Controllers\UserController::class, 'delete']);

Route::post('/update/{id}', [App\Http\Controllers\ImagesController::class, 'update']);

Route::post('/StatusChange/{id}', [App\Http\Controllers\UserController::class, 'statusEdit']);

Route::post('/changeMail/{id}', [App\Http\Controllers\UserController::class, 'editMail']);

Route::post('/edituser/{id}', [App\Http\Controllers\UserController::class, 'editMail']);
