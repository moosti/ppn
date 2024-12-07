<?php

namespace App\Data\CommentData;

use Spatie\LaravelData\Data;

class CommentUpdateData extends Data
{
    public function __construct(
        public string $content,
    ) {}
}
