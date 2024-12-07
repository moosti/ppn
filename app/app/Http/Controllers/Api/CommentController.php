<?php

namespace App\Http\Controllers\Api;

use App\Data\CommentData\CommentStoreData;
use App\Data\CommentData\CommentUpdateData;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Repositories\CommentRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    public function __construct(protected CommentRepositoryInterface $repository) {}

    public function index(Article $article): AnonymousResourceCollection
    {
        $list = $this->repository->listForArticle($article);

        return CommentResource::collection($list);
    }

    public function store(CommentStoreData $data, Article $article): CommentResource
    {
        $data->article_id = $article->id;
        $data->user_id = auth()->id();

        $model = $this->repository->create($data);

        return $this->show($model);
    }

    public function show(Comment|Model $comment): CommentResource
    {
        $comment->loadMissing('user');

        return CommentResource::make($comment);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(CommentUpdateData $data, Comment $comment): CommentResource
    {
        $this->authorize('update', $comment);

        $model = $this->repository->update($comment, $data);

        return $this->show($model);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $this->authorize('delete', $comment);

        $this->repository->delete($comment);

        return $this->apiResponse();
    }
}
