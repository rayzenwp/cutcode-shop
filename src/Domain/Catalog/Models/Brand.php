<?php

namespace Domain\Catalog\Models;

use Support\Traits\Models\HasSlug;
use Database\Factories\BrandFactory;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Models\HasThumbnail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilderContracts;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_home_page',
        'sorting'
    ];

    protected function thumbnailDir(): string
    {
        return 'brands';
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // public function scopeHomePage(Builder $query)
    // {
    //     $query->where('on_home_page', true)
    //         ->orderBy('sorting')
    //         ->limit(6);
    // }

    public function newEloquentBuilder($query)
    {
        return new BrandQueryBuilder($query);
    }

    //1/2 это нужно что бы в тестах или сидах работать от модели Brand::factory()->create(...)
    protected static function newFactory(): Factory
    {
        return BrandFactory::new();
    }
}
