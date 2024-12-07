<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $this->isAdmin($user) || $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $this->isAdmin($user) || $comment->user_id === $user->id;
    }

    private function isAdmin(User $user): bool
    {
        return (bool) $user->is_admin;
    }
}
