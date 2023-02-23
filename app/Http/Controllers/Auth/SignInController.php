<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory;

// NOTE: не согласна с названием, лучше login
class SignInController extends Controller
{
    public function page(): View|Factory|Application|RedirectResponse
    {
        // logger()->channel('telegram')->debug('dd');
        return view('auth.login');
    }

    public function handle(SignInFormRequest $request): RedirectResponse
    {
        //NOTE: возможно код нужно вынести в actions
        if(!auth()->attempt($request->validated())){
            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->onlyInput('email');
        }
      
        $request->session()->regenerate();
 
        return redirect()->intended(route('home'));
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();
 
        request()->session()->invalidate();
     
        request()->session()->regenerateToken();
     
        return redirect()->intended(route('home'));
    }
}
