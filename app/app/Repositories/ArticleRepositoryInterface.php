<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface extends EloquentRepositoryInterface
{
    public function filterPaginate(): LengthAwarePaginator;
}
