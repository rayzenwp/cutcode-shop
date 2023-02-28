<?php declare(strict_types=1);

namespace Tests\Feature\Auth\DTOs;

use Tests\TestCase;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_instance_created_from_form_request(): void
    {
        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '12345',
        ]));
        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}