<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Support\Collection;

class CommentRepository
{
    public function findApproved(): Collection
    {
        return Comment::query()
            ->approved()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findPending(): Collection
    {
        return Comment::query()
            ->pending()
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
