<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\CommentReaction;

interface CommentReactionRepositoryInterface extends EloquentRepositoryInterface
{
    public function like(Comment $comment): ?CommentReaction;

    public function dislike(Comment $comment): ?CommentReaction;
}
