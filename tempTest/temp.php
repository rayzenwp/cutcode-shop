<?php declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\AuthController;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use Domain\Auth\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Testing\Fakes\EventFake;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     * @return void
     */
    public function it_login_page_success(): void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

     /**
     * @test
     * @return void
     */
    public function it_register_page_success(): void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    /**
     * @test
     * @return void
     */
    public function it_forgot_password_page_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    /**
     * @test
     * @return void
     */
    public function it_reset_password_page_success(): void
    {
        $user = User::factory()->create(); 
        $token = Password::createToken($user); 

        $this->get(action([ResetPasswordController::class, 'page'], ['token' => $token]))
            ->assertOk()
            ->assertViewIs('auth.reset-password');
    }

    /**
     * @test
     * @return void
     */
    public function it_login_success(): void
    {
        $password = '12345678';

        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password
        ]);

        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));
        
        $this->assertAuthenticatedAs($user);

    }

    /**
     * @test
     * @return void
     */
    public function it_register_success(): void
    {
        Notification::fake();
        Event::fake();

        // NOTE: вместо фабрики сожно использовать обычный масив
        $request = SignUpFormRequest::factory()->create([
            'email' => 'testing@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        $user = User::query()
            ->where('email', $request['email'])
            ->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response
            ->assertRedirect(route('home'));
    }

    /**
     * @test
     * @return void
     */
    public function it_logout_success(): void
    {
        $user = User::factory()->create([
            'email' => 'testing@yandex.ru'
        ]);

        $this->actingAs($user)->delete(action([SignInController::class, 'logout']));

        $this->assertGuest();
    }

    //дописать тести по ресет паролю и т.д по гитхабу тоже

    public function it_forgot_password_success(): void
    {
        $request = [
            'email' => 'testing@gmail.com',
        ];

        $user = User::factory()->create($request);

        $response = $this->post(action([ForgotPasswordController::class, 'handle']), $request);

        $response
            ->assertValid()
            ->assertRedirect();

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function it_reset_password_success(): void
    {
        $password = '1234567890';
        $password_confirmation = '1234567890';

        $user = User::factory()->create([
            'email' => 'testing@yandex.ru'
        ]);

        $token = Password::createToken($user);

        Password::shouldReceive('reset')
            ->once()
            ->withSomeOfArgs([
                'email' => $user->email,
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'token' => $token
            ])
            ->andReturn(Password::PASSWORD_RESET);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
            'token' => $token
        ]);

        $response->assertRedirect(action([SignInController::class, 'page']));
    }

}