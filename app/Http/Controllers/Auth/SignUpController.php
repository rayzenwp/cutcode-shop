<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\View\Factory;

// NOTE: не согласна с названием, лучше register
class SignUpController extends Controller
{
    public function page(): View|Factory|Application|RedirectResponse
    {
        return view('auth.register');
    }

    public function handle(SignUpFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        // TODO: make DTO
        //NOTE: need try ccatch
        $action($request->validated());

        return redirect()->intended(route('home'));
    }
}
