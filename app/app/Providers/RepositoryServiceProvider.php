<?php

namespace App\Providers;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\CommentReactionRepositoryInterface;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\Eloquent\ArticleRepository;
use App\Repositories\Eloquent\CommentReactionRepository;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $toBind = [
            UserRepositoryInterface::class => UserRepository::class,
            ArticleRepositoryInterface::class => ArticleRepository::class,
            CommentRepositoryInterface::class => CommentRepository::class,
            CommentReactionRepositoryInterface::class => CommentReactionRepository::class,
        ];

        foreach ($toBind as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
