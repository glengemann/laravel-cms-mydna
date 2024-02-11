<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function update(User $user, Comment $comment): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }

    public function destroy(User $user, Comment $comment): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }
}
