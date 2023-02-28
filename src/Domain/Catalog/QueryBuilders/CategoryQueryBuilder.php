<?php

namespace Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

final class CategoryQueryBuilder extends Builder
{
    public function homePage()
    {
        // only build sql query, that get collection use ->get() too
        // alway need use select it fast and select onlt that we need
        return $this->select(['id', 'title', 'slug'])->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(10);
    }

}
