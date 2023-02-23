<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //TODO: ДЗ кастомный фейкер провайдер
        // /images/products/filename.png
        // storage/images/filename
        //сделать как задано и сделать как в видео на ютубе
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'price' => $this->faker->numberBetween(1000 - 100000),

            //через обычный фейкер имейдж работает если заранее сделать папку и без вложеной папки
            //'thumbnail' => $this->faker->image(Storage::path('images/products'), 640, 480, 'technics'),

            // кастомный провайдер фейкера ютуб урок
            // 'thumbnail' => $this->faker->loremflickr('products'),

            // с курса 
            'thumbnail' => $this->faker->fixturesImage('products', 'images/products'),
            
        ];
    }
}
