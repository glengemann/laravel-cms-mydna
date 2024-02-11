<?php

namespace App\Models;

use App\Enums\CommentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property string $content
 * @property int $post_id
 * @property CommentStatus $status
 */
class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($post) {
            $post->user_id = Auth::id();
        });
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->whereStatus(CommentStatus::PENDING->value);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereStatus(CommentStatus::APPROVED->value);
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->whereStatus(CommentStatus::REJECTED->value);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
