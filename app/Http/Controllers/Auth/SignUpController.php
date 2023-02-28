<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
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

    //NOTE: need try catch
    public function handle(SignUpFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        // NewUserDTO::make(...$request->validated())
        $action(NewUserDTO::fromRequest($request));

        return redirect()->intended(route('home'));
    }
}
