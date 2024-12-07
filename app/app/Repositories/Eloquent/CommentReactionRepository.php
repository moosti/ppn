<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Repositories\CommentReactionRepositoryInterface;

class CommentReactionRepository extends BaseRepository implements CommentReactionRepositoryInterface
{
    public function __construct(CommentReaction $model)
    {
        parent::__construct($model);
    }

    public function like(Comment $comment): ?CommentReaction
    {
        return $this->react($comment, 'like');
    }

    public function dislike(Comment $comment): ?CommentReaction
    {
        return $this->react($comment, 'dislike');
    }

    private function react(Comment $comment, string $type): ?CommentReaction
    {
        $data = [
            'comment_id' => $comment->id,
            'user_id' => auth()->id(),
            'type' => $type,
        ];

        $model = $this->findByCriteria($data);

        if ($model) {
            $this->delete($model);

            return null;
        } else {
            return $this->create($data);
        }
    }
}
