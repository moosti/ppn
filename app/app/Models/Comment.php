<?php

namespace App\Models;

use App\Enum\CommentReactionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'parent_id',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(CommentReaction::class, 'comment_id')->where('type', CommentReactionEnum::Like->value);
    }

    public function dislikes(): HasMany
    {
        return $this->hasMany(CommentReaction::class, 'comment_id')->where('type', CommentReactionEnum::Dislike->value);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}
