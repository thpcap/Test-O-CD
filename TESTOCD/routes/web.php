<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AuthController;

Route::get('/people', [PersonController::class, 'index'])->name('people.index')->middleware('auth');
Route::get('/people/create', [PersonController::class, 'create'])->name('people.create')->middleware('auth');
Route::post('/people', [PersonController::class, 'store'])->name('people.store')->middleware('auth');
Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show')->middleware('auth');
Route::get('/degree/{person1_id}/{person2_id}', [PersonController::class, 'degree'])->name('people.degree');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
