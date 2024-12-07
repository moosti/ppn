<?php

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Models\Comment;
use App\Repositories\CommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function listForArticle(Article $article): LengthAwarePaginator
    {
        $perPage = request()->integer('per_page', 10);

        $baseQuery = $this->newQuery()
            ->with('user')
            ->whereBelongsTo($article);

        return QueryBuilder::for($baseQuery)
            ->allowedIncludes([
                'replies.user',
                AllowedInclude::count('repliesCount'),
                AllowedInclude::count('likesCount'),
                AllowedInclude::count('dislikesCount'),
            ])
            ->allowedSorts(['created_at', 'id'])
            ->defaultSort('-id')
            ->paginate($perPage);
    }
}
