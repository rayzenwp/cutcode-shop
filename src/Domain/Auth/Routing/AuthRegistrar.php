<?php

declare(strict_types=1);

namespace Domain\Auth\Routing;

use App\Contracts\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Routing\Registrar;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

final class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {

            Route::controller(SignInController::class)->group(function () {
                Route::get('/login', 'page')
                    ->name('login');
                Route::post('/login', 'handle')
                    ->middleware('throttle:auth')
                    ->name('login.handle');

                // TODO запретить GET /logout (выскакивает ошибка)
                Route::delete('/logout', 'logout')
                    ->name('logout');
            });

            Route::controller(SignUpController::class)->group(function () {
                Route::get('/sign-up', 'page')
                    ->name('register');
                Route::post('/sign-up', 'handle')
                    ->middleware('throttle:auth')
                    ->name('register.handle');
            });

            Route::controller(ForgotPasswordController::class)->group(function () {
                Route::get('/forgot-password', 'page')
                    ->middleware('guest')
                    ->name('forgot');

                Route::post('/forgot-password', 'handle')
                    ->middleware('guest')
                    ->name('forgot.handle');
            });

            Route::controller(ResetPasswordController::class)->group(function () {
                Route::get('/reset-password/{token}', 'page')
                    ->middleware('guest')
                    ->name('password.reset');

                Route::post('/reset-password', 'handle')
                    ->middleware('guest')
                    ->name('password-reset.handle');
            });

            Route::controller(SocialAuthController::class)->group(function () {

                Route::get('/auth/socialite/{driver}', 'redirect')
                    ->name('socialite.redirect');

                Route::get('/auth/socialite/{driver}/callback', 'callback')
                    ->name('socialite.callback');
            });
        });
    }
}