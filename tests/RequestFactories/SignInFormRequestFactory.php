<?php

namespace Tests\RequestFactories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Worksome\RequestFactories\RequestFactory;

class SignInFormRequestFactory extends RequestFactory
{
  use HasFactory;

    public function definition(): array
    {
        return [
          'email' => $this->faker->email,
        ];
    }
}
