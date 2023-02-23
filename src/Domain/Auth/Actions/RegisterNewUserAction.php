<?php declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

final class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(array $data)
    {
        //NOTE: почему нельзя просто User::create()
        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        event(new Registered($user));

        auth()->login($user);
    }
}