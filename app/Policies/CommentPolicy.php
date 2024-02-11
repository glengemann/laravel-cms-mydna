<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class CommentPolicy
{
    public function update(User $user, Post $post): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }

    public function destroy(User $user, Post $post): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }
}
