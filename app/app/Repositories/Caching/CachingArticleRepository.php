<?php

namespace App\Repositories\Caching;

use App\Repositories\ArticleRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CachingArticleRepository
{
    public function __construct(protected ArticleRepositoryInterface $repository) {}

    public function filterPaginate()
    {
        $key = sprintf('%s_%s', config('cache.sections.articles.filter_paginate.key'), md5(json_encode(request()->all())));
        $ttl = config('cache.sections.articles.filter_paginate.ttl');

        return Cache::tags(config('cache.sections.articles.tag'))->remember($key, $ttl, function () {
            return $this->repository->filterPaginate();
        });
    }
}
