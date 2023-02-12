<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('price')->default(0);

            // Здесь в миграциях мы создаем  отношения в рамках Eloquent orm
            //миграции это слой базы данных и никакого отношения к ларавелю не имеет
            
            $table->foreignIdFor(Brand::class) //создание поля тип и т.д
                ->nullable()
                ->constrained() // внешний ключ в базе
                ->cascadeOnUpdate() // как будет вести себя база при обновлнении
                // ->cascadeOnDelete() // если бренд удалиться то и удалятся все товары
                ->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Category::class) 
                ->constrained() 
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(Product::class) 
                ->constrained() 
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        }); 
    }

    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('category_product');
            Schema::dropIfExists('products');
        }
    }
};
