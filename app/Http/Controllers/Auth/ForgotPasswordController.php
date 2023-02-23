<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function page(): View|Factory|Application|RedirectResponse
    {
        return view('auth.forgot-password');
    }

    public function handle(ForgotPasswordFormRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
       
        if ($status === Password::RESET_LINK_SENT) {
            flash()->info(__($status));

            return back();
        }
       
        return back()->withErrors(['email' => __($status)]);
    }
}
