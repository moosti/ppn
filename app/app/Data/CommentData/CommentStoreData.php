<?php

namespace App\Data\CommentData;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;

class CommentStoreData extends Data
{
    public function __construct(
        public string $content,
        #[Exists(Article::class, 'id')]
        public ?int $article_id,
        #[Exists(User::class, 'id')]
        public ?int $user_id,
        #[Exists(Comment::class, 'id')]
        public ?int $parent_id,
    ) {}
}
