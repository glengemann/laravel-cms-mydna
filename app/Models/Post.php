<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $category_id
 */
class Post extends Model
{
    use FilterTrait;
    use HasFactory;

    protected $guarded = [];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($post) {
            $post->user_id = Auth::id();
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class);
    }
}
