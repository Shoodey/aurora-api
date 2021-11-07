<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'App\Http\Controllers\API\Auth\LoginController@login')->name('login');
Route::post('register', 'App\Http\Controllers\API\Auth\RegisterController@register')->name('register');

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', 'App\Http\Controllers\API\Auth\LoginController@logout')->name('logout');
});
