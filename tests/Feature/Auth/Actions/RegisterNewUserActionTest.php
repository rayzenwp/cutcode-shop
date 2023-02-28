<?php declare(strict_types=1);

namespace Tests\Feature\Auth\DTOs;

use Tests\TestCase;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_success_user_created(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' =>  'testing@gmail.com'
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make('Test', 'testing@gmail.com', '123456778990'));

        $this->assertDatabaseHas('users', [
            'email' =>  'testing@gmail.com'
        ]);
    }
}