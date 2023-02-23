<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use DomainException;
use Domain\Auth\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $driver): RedirectResponse
    {
        try {
            return Socialite::driver($driver)
                ->redirect();
        } catch (Throwable $exception) {
            throw new DomainException('Произошла ошибка или драйвер не поддерживается');
        }

    }

    public function callback(string $driver): RedirectResponse
    {
        if ($driver !== 'github') {
            throw new DomainException('Драйвер не поддерживается');
        }
        
        $githubUser = Socialite::driver($driver)->user();
        
        // TODO: move to custom table social_auth
        // ключ провайдера = ключ его айди
        // user_id | github | github_id
        // и тут проверка не сразу юзер модел а проверит связаную таблицу 
        // если там есть привязка то авторизуем иначе создаем две сущности

        //NOTE: в видео User::query()

         //TODO если есть созданный не через гитхаб пользователь, то Duplicate entry
          
        $user = User::query()->updateOrCreate([
            $driver.'_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name ?? $githubUser->nickname,
            'email' => $githubUser->email,
            'password' => bcrypt(str()->random(20)),
            // 'github_token' => $githubUser->token,
            // 'github_refresh_token' => $githubUser->refreshToken,
        ]);
        
        auth()->login($user);
        
        return redirect()->intended(route('home'));
    
    }
}
