<?php

namespace App\Http\Controllers\Api;

use App\Data\ArticleData\ArticleStoreData;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Notifications\ArticleCreatedNotification;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\Caching\CachingArticleRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleRepositoryInterface $repository,
        protected CachingArticleRepository $cachingArticleRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $list = $this->cachingArticleRepository->filterPaginate();

        return ArticleResource::collection($list);
    }

    public function store(ArticleStoreData $data): ArticleResource
    {
        $data->user_id = auth()->id();
        /** @var Article $model */
        $model = $this->repository->create($data);

        if ($admin = $this->userRepository->findFirstAdmin()) {
            Notification::send([$admin], new ArticleCreatedNotification($model));
        }

        return $this->show($model);
    }

    public function show(Article|Model $article): ArticleResource
    {
        $article->loadMissing(['user']);

        return ArticleResource::make($article);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(ArticleStoreData $data, Article $article): ArticleResource
    {
        $this->authorize('update', $article);

        $model = $this->repository->update($article, $data);

        return $this->show($model);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Article $article): Response
    {
        $this->authorize('delete', $article);

        $this->repository->delete($article);

        return response()->noContent();
    }
}
