<?php

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Repositories\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
{
    public function __construct(Article $model)
    {
        parent::__construct($model);
    }

    public function filterPaginate(): LengthAwarePaginator
    {
        $perPage = request()->integer('per_page', 15);

        return QueryBuilder::for($this->newQuery())
            ->allowedFilters(['title', 'slug'])
            ->allowedSorts(['title', 'slug'])
            ->allowedIncludes(['comments.user'])
            ->defaultSort('-id')
            ->paginate($perPage);
    }
}
