<?php

declare(strict_types=1);

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

// NOTE: good solution too this use spatie ViewModels
final class CategoryViewModel
{
    use Makeable;

    public function homePage(): Collection|array
    {
        // Note: добавить обсервер на категорию если в базе изменения то сбросить кеш
        return Cache::rememberForever('category_home_page', function () {
            return Category::query()
                ->homePage()
                ->get();
        });
    }
}