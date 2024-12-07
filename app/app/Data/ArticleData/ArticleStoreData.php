<?php

namespace App\Data\ArticleData;

use App\Models\Article;
use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class ArticleStoreData extends Data
{
    public function __construct(
        public string $title,
        #[Unique(Article::class, 'slug', ignore: new RouteParameterReference('article', 'id', true))]
        public string $slug,
        public string $summary,
        public string $content,
        #[Exists(User::class, 'id')]
        public ?int $user_id,
    ) {}
}
