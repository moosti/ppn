<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Repositories\CommentReactionRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CommentReactionController extends Controller
{
    public function __construct(protected CommentReactionRepositoryInterface $repository) {}

    public function like(Comment $comment): JsonResponse
    {
        $result = $this->repository->like($comment);

        return $this->response($result);
    }

    public function dislike(Comment $comment): JsonResponse
    {
        $result = $this->repository->dislike($comment);

        return $this->response($result);
    }

    private function response(?CommentReaction $result): JsonResponse
    {
        $message = is_null($result) ? 'removed' : 'created';

        return $this->apiResponse(data: $result, message: $message);
    }
}
