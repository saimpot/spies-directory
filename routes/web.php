<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', static fn () => 'This application does not have a frontend. Use the API.')->name('landing');
Route::get('/login', static fn () => 'You have been redirected here, because you are not logged in. Please use the artisan command "api:create-user" to create a user and use the token provided to authenticate yourself with the API.')
    ->name('login');
