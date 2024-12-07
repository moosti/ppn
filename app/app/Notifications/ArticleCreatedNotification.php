<?php

namespace App\Notifications;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ArticleCreatedNotification extends Notification
{
    use Queueable;

    private Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
        $this->onConnection('redis');
    }

    public function viaConnections(): array
    {
        return [
            'mail' => 'redis',
            'database' => 'sync',
        ];
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Article created'))
            ->line('Article Title: '.$this->article->title)
            ->line('Article Summary: '.$this->article->summary)
            ->line('Article CreatedAt: '.$this->article->created_at->toDateTimeString());
    }

    public function toArray(object $notifiable): array
    {
        $this->article->loadMissing(['user']);

        return [
            'article' => ArticleResource::make($this->article)->resolve(),
        ];
    }

    public function failed(\Exception $exception): void
    {
        $logMessage = sprintf('ArticleCreatedNotification failed for article id: %s with exception: %s'.$this->article->id, $exception->getMessage());
        Log::error($logMessage);
    }
}
