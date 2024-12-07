<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        return $this->isAdmin($user) || $article->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        return $this->isAdmin($user) || $article->user_id === $user->id;
    }

    private function isAdmin(User $user): bool
    {
        return (bool) $user->is_admin;
    }
}
