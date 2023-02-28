<?php

namespace Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

final class BrandQueryBuilder extends Builder
{
    public function homePage()
    {
        // only build sql query, that get collection use ->get() too
        return $this->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

}
