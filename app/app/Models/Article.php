<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'summary',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    protected static function flushCache(): void
    {
        Cache::tags(config('cache.sections.articles.tag'))->flush();
    }

    protected static function boot(): void
    {
        parent::boot();

        // create or update
        static::saving(function ($model) {
            $model->user_id = $model->user_id ?? auth()->id();
            self::flushCache();
        });

        static::deleted(function ($model) {
            self::flushCache();
        });
    }
}
