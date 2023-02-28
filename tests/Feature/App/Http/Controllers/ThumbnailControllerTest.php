<?php declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Database\Factories\CategoryFactory;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_success_response(): void
    {
    }
}