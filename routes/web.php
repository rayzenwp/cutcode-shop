<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

    //Query builder 
    // dump(Product::query()
    //     ->select('id', 'title', 'brand_id')
    //     ->with(['categories', 'brand'])
    //     ->where('id', 1)
    //     // ->toSql()
    //     ->get()
    // );
    
Route::controller(AuthController::class)->group(function(){

    // TODO: rename routes

    Route::get('/login', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'signIn')
        ->middleware(['guest', 'throttle:auth'])
        ->name('signIn');

    Route::get('/sign-up', 'signUp')->middleware('guest')->name('signUp');
    Route::post('/sign-up', 'store')
        ->middleware(['guest', 'throttle:auth'])
        ->name('store');

    Route::delete('/logout', 'logout')->name('logout');

    Route::get('/forgot-password', 'forgot')->middleware('guest')->name('password.request');
    Route::post('/forgot-password', 'forgotPassword')
        ->middleware('guest')
        ->name('password.email');

    Route::get('/reset-password/{token}', 'reset')->middleware('guest')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')
        ->middleware('guest')
        ->name('password.update');

    Route::get('/auth/socialite/github', 'github')->name('socialite.github');
    Route::get('/auth/socialite/github/callback', 'githubCallback')->name('socialite.github.callback');
});

Route::get('/', HomeController::class)->name('home');


