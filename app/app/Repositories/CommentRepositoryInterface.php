<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CommentRepositoryInterface extends EloquentRepositoryInterface
{
    public function listForArticle(Article $article): LengthAwarePaginator;
}
